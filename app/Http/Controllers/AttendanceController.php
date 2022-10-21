<?php

  namespace App\Http\Controllers;

  use App\Models\AttendanceManager;
  use App\Models\AttendanceFilename;
  use App\Repositories\ExportRepository;
  use App\Repositories\ImportAttendanceData;
  use App\Repositories\UploadRepository;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Input;

  use App\Models\Attendance_management;
  use App\Models\Reason;
  use Session;
  use Stevebauman\Location\Facades\Location;
  use Carbon\Carbon;
  use Illuminate\Support\Facades\DB;

  class AttendanceController extends Controller
  {
    public $export;
    public $upload;
    public $attendanceData;

    /**
     * AttendanceController constructor.
     * @param ExportRepository $exportRepository
     * @param UploadRepository $uploadRepository
     * @param ImportAttendanceData $attendanceData
     */
    public function __construct(ExportRepository $exportRepository, UploadRepository $uploadRepository, ImportAttendanceData $attendanceData)
    {
      $this->export = $exportRepository;
      $this->upload = $uploadRepository;
      $this->attendanceData = $attendanceData;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importAttendanceFile()
    {
      $files = AttendanceFilename::paginate(10);
      return view('hrms.attendance.upload_file', compact('files'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFile(Request $request)
    {
      if (Input::hasFile('upload_file')) {
        $file = Input::file('upload_file');
          $filename = $this->upload->File($file, $request->description, $request->date);

        try {
          if($filename) {
            $this->attendanceData->Import($filename);
          }
        } catch(\Exception $e) {

          \Session::flash('flash_message1', $e->getMessage());

          \Log::info($e->getLine(). ' '. $e->getFile());
          return redirect()->back();
        }
      }
      else {

        return redirect()->back()->with('flash_message', 'Please choose a file to upload');
      }



      \Session::flash('flash_message1', 'File successfully Uploaded!');
      return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSheetDetails()
    {
      $column = '';
      $string = '';
      $dateFrom = '';
      $dateTo = '';
      $attendances = AttendanceManager::paginate(20);
      return view('hrms.attendance.show_attendance_sheet_details', compact('attendances', 'column', 'string', 'dateFrom', 'dateTo'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDelete($id)
    {
      $file = AttendanceFilename::find($id);
      $file->delete();

      \Session::flash('flash_message1', 'File successfully Deleted!');
      return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function searchAttendance(Request $request)
    {
      try {
        $string = $request->string;
        $column = $request->column;

        $dateTo = date_format(date_create($request->dateTo), 'd-m-Y');
        $dateFrom = date_format(date_create($request->dateFrom), 'd-m-Y');

        if ($request->button == 'Search') {
          /**
           * send the post data to getFilteredSearchResults function
           * of AttendanceManager class in Models folder
           */
          $attendances = AttendanceManager::getFilterdSearchResults($request->all());
          return view('hrms.attendance.show_attendance_sheet_details', compact('attendances', 'column', 'string', 'dateFrom', 'dateTo'));
        }
        else
        {
          if ($column && $string) {
            if ($column == 'status') {
              $string = convertAttendanceTo($string);
            }
            $attendances = AttendanceManager::whereRaw($column . " like '%" . $string . "%'")->get();
          } else {
            $attendances = AttendanceManager::get();
          }

          $fileName = 'Attendance_Listing_' . rand(1, 1000). '.csv';
          $filePath = storage_path('export/').$fileName;
          $file = new \SplFileObject($filePath, "a");
          $headers = ['id', 'name', 'code', 'date', 'day', 'in_time', 'out_time', 'hours_worked', 'difference', 'status', 'leave_status', 'user_id', 'created_at', 'updated_at'];
          $file->fputcsv($headers);
          foreach($attendances as $attendance)
          {
                $file->fputcsv([$attendance->id,$attendance->name,$attendance->code,$attendance->date,$attendance->day,$attendance->in_time,$attendance->out_time,$attendance->hours_worked,$attendance->difference,$attendance->status,$attendance->leave_status]);
            }



            /**
           * sending the results fetched in above query to exportData
           * function of ExportRepository class located in
           * app\Repositories folder
           */

         // $fileName = $this->export->exportData($attendances, $file, $headers);

          return response()->download(storage_path('export/') . $fileName);
        }

      } catch (\Exception $e) {
        return redirect()->back()->with('message', $e->getMessage());
      }
    }

    public function taskslogin()
    {
      $id = Session::get('user');

      $currentDateTime = Carbon::now();
      $time1 = $currentDateTime->toTimeString();

      $data = Attendance_management::where('user_id', '=', $id)
      ->where('status', "=" , '1')->get();
      $out = "";
     
      if(count($data) == 1){
        $out = 'out';

        return view('hrms.attendance.login',['out' => $out, 'time1' => $time1]);

      }
      return view('hrms.attendance.login',['out' => $out, 'time1' => $time1]);
    }

    public function process_task_login(Request $request)
    {
      $id = Session::get('user');      

      $currentDateTime = Carbon::now();
      $date = $currentDateTime->toDateString();

      $ip = '103.57.142.14'; 

      $currentUserInfo = Location::get($ip);

      $city = $currentUserInfo->cityName;
      $state = $currentUserInfo->regionName;
      $location = [$city,$state];
      $locations = json_encode($location);

      $find = Attendance_management::where('user_id', '=', $id)
      ->where('status', "=" , "1")->get();

      if(count($find) == 0)
      {       

        $data = new Attendance_management();
        $data->user_id = $id;
        $data->project_id = 0;
        $data->in_task = $request->task;
        $data->location = $locations;
        $data->in_date = $currentDateTime->toDateString();
        $data->in_time = $currentDateTime->toTimeString();
        $data->status = 1;
        $data->save();

        if($request->reason != ""){

          $result = Attendance_management::where('user_id', "=" , $id, )
          ->where('status', "=" , "1")->first();

          $reason = new Reason();
          $reason->attend_id = $result->id;
          $reason->reason = $request->reason;
          $reason->accepted = 0;
          $reason->save();
        }
         
        return redirect('dashboard');
      }
      else
      {
        $result = Attendance_management::where('user_id', '=', $id)
        ->where('status', "=" , "1")->first();
        
        $result->user_id = $result->user_id;
        $result->project_id = 0;
        $result->in_task = $result->in_task;
        $result->out_task = $request->task1;
        $result->location = $result->location;
        $result->in_date = $result->in_date;
        $result->out_date = $currentDateTime->toDateString();
        $result->in_time = $result->in_time;
        $result->out_time = $currentDateTime->toTimeString();
        $result->status = 0;       
        $result->save();

        return redirect('welcome');
      }

    }

    public function attendance_list(){

      $data = Attendance_management::with('employee')->get(); 

      $column = '';
		  $string = '';
		  $dateFrom = '';
		  $dateTo = '';

      return view('hrms.attendance.show_attendance_list', compact('data', 'column', 'string', 'dateFrom', 'dateTo'));
    }


    public function searchlist(Request $request) {
      try
      {
        $string = $request->string;
  
        $column = $request->column;
        $dateTo = $request->dateTo;
        $dateFrom = $request->dateFrom;
  
        $data = ['name' => 'users.name', 'department' => 'employee.department', 'days' => 'employee_leaves.days', 'leave_type' => 'leave_types.leave_type', 'status' => 'employee_leaves.status'];
        
       
  
        if ($request->button == 'Search') {
          
          /**
           * First we build a query string which is common in both cases whether we have a condition set or not
           */
          $data1 = \DB::table('users')->select(
             'users.name', 'attendance_managements.*','employee.department')
            ->join('attendance_managements', 'users.id', '=', 'attendance_managements.user_id')
            ->join('employee', 'users.id', '=', 'employee.user_id');
          if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
            $data1 = $data1->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
            // return $data;
          } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $data1 = $data1->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
          } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $data1 = $data1->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
          } else {
            $data1 = $data1->paginate(20);
          }
          $post = 'post';

          // return $data;
  
          return view('hrms.attendance.show_attendance_list', compact('data1', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
        } else {
          /**
           * First we build a query string which is common in both cases whether we have a condition set or not
           */
          $leaves = \DB::table('users')->select('users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks')->join('employees', 'employees.user_id', '=', 'users.id')->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');
  
          if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
            $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
          } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->get();
          } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->get();
          } else {
            $leaves = $leaves->get();
          }
          /*$leaves = $leaves->get();*/
  
          $fileName = 'Leave_Listing_' . rand(1, 1000) . '.csv';
          $filePath = storage_path('export/') . $fileName;
          $file = new \SplFileObject($filePath, "a");
          // Add header to csv file.
          $headers = ['id', 'name', 'code', 'leave_type', 'date_from', 'date_to', 'days', 'status', 'remarks', 'created_at', 'updated_at'];
          $file->fputcsv($headers);
          $status = '';
          foreach ($leaves as $leave) {
            if ($leave->status == 0) {
              $status = 'Pending';
            } elseif ($leave->status == 1) {
              $status = 'Approved';
            } elseif ($leave->status == 2) {
              $status = 'Disapproved';
            }
            $file->fputcsv([$leave->id, $leave->name, $leave->code, $leave->leave_type, $leave->date_from, $leave->date_to, $leave->days, $status, $leave->remarks]);
          }
  
          return response()->download(storage_path('export/') . $fileName);
  
        }
      } catch (\Exception $e) {
        return redirect()->back()->with('message', $e->getMessage());
      }
    }


    
  }






