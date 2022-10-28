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
        // $invites = TrainingInvite::with(['employee','program'])->paginate(15);
        
        $invites = \DB::table('users')->select(
        'users.name', 'training_invites.id','training_programs.name as program_name', 'training_programs.description', 'training_programs.date_from','training_programs.date_to')
       ->join('training_invites', 'users.id', '=', 'training_invites.user_id')
       ->join('training_programs', 'training_invites.program_id', '=', 'training_programs.id')
       ->get();   
       
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
	
		$string = $request->string;
		$column = $request->column;

        $invites = \DB::table('users')->select(
            'users.name', 'training_invites.id','training_programs.name as program_name', 'training_programs.description', 'training_programs.date_from','training_programs.date_to')
           ->join('training_invites', 'users.id', '=', 'training_invites.user_id')
           ->join('training_programs', 'training_invites.program_id', '=', 'training_programs.id'); 

        if ($request->button == 'Search') {
            if ($string == '' && $column == '') {
				\Session::flash('success', ' Employee details uploaded successfully.');
				return redirect()->to('show-training-invite');
			} elseif ($string != '' && $column == '') {
				\Session::flash('failed', ' Please select category.');
				return redirect()->to('show-training-invite');
			} elseif ($column == 'name') {
                // $invites = $invites->where($column, 'like', "%$string%")->paginate(20);
                $invites = $invites->whereRaw($column . " like '%" . $string . "%' ")->paginate(20);
                return $invites;
				// $emps = User::with('employee')->where($column, 'like', "%$string%")->paginate(20);
			} else {
				$invites = TrainingInvite::whereHas('employee', function ($q) use ($column, $string) {
					$q->whereRaw($column . " like '%" . $string . "%'");
				}
				)->with('employee')->paginate(20);
			}

            return view('hrms.training.show_training_invite',compact('invites' , 'string', 'column'));
			// return view('hrms.employee.show_emp', compact('emps', 'column', 'string')); 
            }
		
	}
    
}
