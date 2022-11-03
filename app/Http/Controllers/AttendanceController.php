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
  use Maatwebsite\Excel\Facades\Excel;

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

      // $list = Attendance_management::with('employee')->get(); 
      $list = \DB::table('users')->select(
        'users.name', 'attendance_managements.*')
       ->join('attendance_managements', 'users.id', '=', 'attendance_managements.user_id')
       ->get();

      $column = '';
		  $string = '';
		  $dateFrom = '';
		  $dateTo = '';

      return view('hrms.attendance.show_attendance_list', compact('list', 'column', 'string', 'dateFrom', 'dateTo'));
    }


    public function searchlist(Request $request) {
      try
      {
        $string = $request->string;
        $column = $request->column;
        $dateTo = $request->dateTo;
        $dateFrom = $request->dateFrom;
  
        $data = ['name' => 'users.name', 'department' => 'employees.department'];
  
        if ($request->button == 'Search') {
          
          /**
           * First we build a query string which is common in both cases whether we have a condition set or not
           */          

          $list = \DB::table('users')->select(
             'users.name', 'attendance_managements.*','employees.department')
            ->join('attendance_managements', 'users.id', '=', 'attendance_managements.user_id')
            ->join('employees', 'users.id', '=', 'employees.user_id');
          if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
            $list = $list->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
            
          } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $list = $list->whereBetween('in_date', [$dateFrom, $dateTo])->paginate(20);
          } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $list = $list->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('in_date', [$dateFrom, $dateTo])->paginate(20);
          } else {
            $list = $list->paginate(20);
          }
          $post = 'post';

  
          return view('hrms.attendance.show_attendance_list', compact('list', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
        } 
        else {
          /**
           * First we build a query string which is common in both cases whether we have a condition set or not
           */
          // $list = \DB::table('users')->select('users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks')->join('employees', 'employees.user_id', '=', 'users.id')->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');
  
          $list = \DB::table('users')->select(
            'users.name', 'attendance_managements.*','employees.*')
           ->join('attendance_managements', 'users.id', '=', 'attendance_managements.user_id')
           ->join('employees', 'users.id', '=', 'employees.user_id');

          if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
            
            $list = $list->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
          } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $list = $list->whereBetween('in_date', [$dateFrom, $dateTo])->get();
          } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
            $list = $list->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('in_date', [$dateFrom, $dateTo])->get();
          } else {
            $list = $list->get();
          }
          
          /*$leaves = $leaves->get();*/
          $fileName = 'attendance_Listing_' . rand(1, 1000) . '.csv';
          
          $filePath = storage_path('export/') . $fileName;
          // return 'dsfkjndsbvckjbnds';
          $file = new \SplFileObject($filePath, "a");
          
          // Add header to csv file.
          $headers = ['id', 'code', 'name', 'department', 'date_from', 'date_to', 'in_time', 'out_time', 'worked_time'];
          $file->fputcsv($headers);
          
          foreach ($list as $leave) {

            $t1 = Carbon::createFromFormat('H:i:s',$leave->in_time);
            $t2 = Carbon::createFromFormat('H:i:s', $leave->out_time);
            $diff = $t1->diff($t2);
            $hours = $diff->h." Hours";
            $min = $diff->i." min";
            $sec = $diff->s." sec";
            $worked_time = $hours." ". $min." ".$sec;

            $file->fputcsv([$leave->id, $leave->code, $leave->name, $leave->department,  date('d-m-Y', strtotime($leave->in_date)), date('d-m-Y', strtotime($leave->out_date)), $leave->in_time, $leave->out_time, $worked_time]);
          }
         
  
          return response()->download(storage_path('export/') . $fileName);
  
        }
      } catch (\Exception $e) {
        return redirect()->back()->with('message', $e->getMessage());
      }
    }

    function task_view($id)
    {
      $data = Attendance_management::with('employee')->where('id', $id)->get();
     
      foreach($data as $values){
        $intime = $values->in_time;
        $outtime = $values->out_time;
      }
      
      if($intime !="" && $outtime!=""){

        $t1 = Carbon::createFromFormat('H:i:s',$intime);
        $t2 = Carbon::createFromFormat('H:i:s', $outtime);
       
        $diff = $t1->diff($t2);

      }else{
        $diff = "";
      }
     
     
      return view('hrms.attendance.show_tasks', ['data'=>$data, 'diff'=>$diff]);

    }
    
  }






