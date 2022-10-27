<?php

namespace App\Http\Controllers;

use App\TrainingInvite;
use App\TrainingProgram;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    public function addTrainingProgram(){
        return view('hrms.training.add_program');
    }

    public function processTrainingProgram(Request $request){
       $programs = new TrainingProgram();
       $programs->name = $request->name;
       $programs->description = $request->description;
       $programs->date_from = $request->date_from;
       $programs->date_to = $request->date_to;
       $programs->save();

        \Session::flash('flash_message', 'Training Program successfully added!');
        return redirect()->back();

    }

    public function showTrainingProgram(){
        $programs = TrainingProgram::paginate(10);
        return view('hrms.training.show_program',compact('programs'));
    }

    public function doEditTrainingProgram($id){
        $programs = TrainingProgram::whereid($id)->first();
        return view('hrms.training.edit_program', compact('programs'));

    }

    public function processEditTrainingProgram($id,Request $request){
        $name = $request->name;
        $description = $request->description;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $edit = TrainingProgram::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        if (!empty($description)) {
            $edit->date_from = $date_from;
        }
        if (!empty($description)) {
            $edit->date_to = $date_to;
        }
        $edit->save();

        \Session::flash('flash_message', 'Training Program successfully updated!');
        return redirect('show-training-program');

    }
    public function deleteTrainingProgram($id){
        $program = TrainingProgram::find($id);
        $program->delete();

        \Session::flash('flash_message', 'Training Program successfully deleted!');
        return redirect('show-training-program');
    }

    public function addTrainingInvite(){

        $emps=User::get();
        $programs= TrainingProgram::get();
        return view('hrms.training.add_training_invite',compact('emps','programs'));
    }

    public function processTrainingInvite(Request $request)
    {

        $totalMembers = count($request->member_ids);
        $i = 0;
        try
        {
            foreach ($request->member_ids as $member_id)
            {
                $check = TrainingInvite::where(['program_id' => $request->program_id, 'user_id' => $member_id])->first();
                if(!$check)
                {
                    $invites = new TrainingInvite();
                    $invites->user_id = $member_id;
                    $invites->program_id = $request->program_id;
                    $invites->description = $request->description;
                    $invites->date_from = date_format(date_create($request->date_from), 'Y-m-d');
                    $invites->date_to = date_format(date_create($request->date_to), 'Y-m-d');
                    $invites->save();
                    $i++;
                }
            }
        }
        catch(\Exception $e)
        {
            \Log::info($e->getMessage(). ' on '. $e->getLine(). ' in '. $e->getFile());
        }

        \Session::flash('flash_message', $i . ' out of '. $totalMembers. ' members have been invited for the training!');
        return redirect()->back();
    }

    public function showTrainingInvite()
    {
        $invites = TrainingInvite::with(['employee','program'])->paginate(15);

        $string = "";
        $column = "";
        return view('hrms.training.show_training_invite',compact('invites' , 'string', 'column'));
    }

    public function doEditTrainingInvite($id)
    {
        $training = TrainingInvite::with(['employee', 'program'])->findOrFail($id);
        $programs = TrainingProgram::get();
        foreach($programs as $program)
        {
            $prog[$program->id] = $program->name;
        }
        $training->programs = $prog;
        return view('hrms.training.edit_training_invite', compact('training'));
    }

    public function processEditTrainingInvite($id, Request $request)
    {
        $model = TrainingInvite::where('id', $id)->firstOrFail();
        $model->program_id = $request->program_id;
        $model->description = $request->description;
        $model->date_from = $request->date_from;
        $model->date_to = $request->date_to;
        $model->save();

        \Session::flash('flash_message', 'Training Program successfully updated!');
        return redirect('show-training-invite');
    }

    public function deleteTrainingInvite($id){
            $invite = TrainingInvite::where('id',$id);
            $invite->delete();

            \Session::flash('flash_message', 'Member successfully removed!');
            return redirect('show-training-invite');
    }

    public function search_program(Request $request){

        $training_id = $request->name;
        $data = TrainingProgram::where('id',$training_id)->first();

        
            return json_encode(array("description" => $data->description ,"date_from" => $data->date_from, "date_to" => $data->date_to,));
    

    }


    public function filter_program(Request $request) {
		try
		{
			$string = $request->string;
			$column = $request->column;

			$data = ['name' => 'users.name', 'code' => 'employees.code', 'days' => 'employee_leaves.days', 'leave_type' => 'leave_types.leave_type', 'status' => 'employee_leaves.status'];

			if ($request->button == 'Search') {
				/**
				 * First we build a query string which is common in both cases whether we have a condition set or not
				 */
				$leaves = \DB::table('employees')->select(
					'users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from',
					'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks')
					->join('employees', 'employees.user_id', '=', 'users.id')
					->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')
					->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');
				if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
					$leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
				} elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
					$dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
					$dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
					$leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
				} elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
					$dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
					$dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
					$leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
				} else {
					$leaves = $leaves->paginate(20);
				}
				$post = 'post';

				return view('hrms.leave.total_leave_request', compact('leaves', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
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
