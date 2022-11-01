<?php

namespace App\Http\Controllers;

use App\TrainingInvite;
use App\TrainingProgram;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mail\Invite_mail;
use Mail;
use Carbon\Carbon;
use App\ScheduleLecture;

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
        $programs->date_from = date('Y-m-d', strtotime($request->date_from));
        $programs->date_to = date('Y-m-d', strtotime($request->date_to));
        $programs->lecture = $request->lecture;
        $programs->days = json_encode($request->day_ids);
        $programs->time = $request->time;

        $date1 = date('Y-m-d', strtotime($request->date_from));
        $date2 = date('Y-m-d', strtotime($request->date_to));

        $programs->save();
        $id =  $programs->id;

        $startDate = new Carbon($date1);
        $endDate = new Carbon($date2);
        $all_dates = array();
        while ($startDate->lte($endDate)){
//   return  date('l',strtotime($startDate->toDateString()));
            $all_dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
       
        $this->schedulelecture($id, $all_dates);

        \Session::flash('flash_message', 'Training Program successfully added!');
        return redirect()->back();

    }


    public function schedulelecture($id, $all_dates){

        $program = TrainingProgram::where('id', '=',$id)->first();
        $days = json_decode($program->days);
    
        foreach($all_dates as $date){

            foreach($days as $day){
                $data = date('l',strtotime($date));
               
                if($day == $data){
                    $lecture =  new ScheduleLecture();
                    $lecture->program_id = $id;
                    $lecture->date_on = $date;
                    $lecture->save();
                }
                
            }
        }
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

        $post = 1;
        $program_id = $id;
        $name = $request->name;
        $description = $request->description;
        $date_from = date('Y-m-d', strtotime($request->date_from));
        $date_to = date('Y-m-d', strtotime($request->date_to));
        $days = json_encode($request->day_ids);
        $time = $request->time;

        $edit = TrainingProgram::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        if (!empty($date_from)) {
            $edit->date_from = $date_from;
        }
        if (!empty($date_to)) {
            $edit->date_to = $date_to;
        }
        if (!empty($days)) {
            $edit->days = $days;
        }
        if (!empty($time)) {
            $edit->time = $time;
        }
        $edit->save();

        $lecture =  ScheduleLecture::where('program_id','=', $program_id)->delete();

        $startDate = new Carbon($date_from);
        $endDate = new Carbon($date_to);
        $all_dates = array();
        while ($startDate->lte($endDate)){
            $all_dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
       
        $this->schedulelecture($id, $all_dates);

        $invites = TrainingInvite::where('program_id', $program_id)->get();
        $email = [];

        if(count($invites) > 0){
            foreach($invites as $invite){
                $email[] .= $invite->user_id;
           }

            $this->invite_mail($email, $program_id, $date_from, $date_to,$post);

        }

       
       

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

        $post = "";
        $email = [];
        $program_id = $request->program_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

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
                    $email[] += $member_id;
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
        $this->invite_mail($email, $program_id, $date_from, $date_to, $post);
        return redirect('dashboard');  

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

        $data = ['name' => 'users.name', 'program' => 'training_programs.name'];

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
                $invites = $invites->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
			} elseif ($column == 'program') {
                $invites = $invites->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
			} else {
                $invites = $invites->paginate(20);
            }
            return view('hrms.training.show_training_invite',compact('invites' , 'string', 'column'));

        }else{

            if ($string != '' && $column == '') {
				\Session::flash('failed', ' Please select category.');
				return redirect()->to('show-training-invite');
			} elseif ($column == 'name') {
                $invites = $invites->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
			} elseif ($column == 'program') {
                $invites = $invites->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();			
            } else {
                $invites = $invites->get();
            } 

           

            $fileName = 'Program_Listing_' . rand(1, 1000) . '.csv';
				$filePath = storage_path('export/') . $fileName;
				$file = new \SplFileObject($filePath, "a");
				// Add header to csv file.
				$headers = ['id', 'name', 'program name', 'description', 'date_from', 'date_to'];
				$file->fputcsv($headers);
				$id = 1;
				foreach ($invites as $invite) {
					
					$file->fputcsv([$id, $invite->name, $invite->program_name, $invite->description, $invite->date_from, $invite->date_to ]);
                    $id+=1;
				}

				return response()->download(storage_path('export/') . $fileName);

        }
		
	}

    function invite_mail($email, $program_id, $date_from, $date_to, $post){
     
        $program = TrainingProgram::where('id', '=', $program_id)->first();
        $program_name = $program->name;
        $program_time = $program->time;

        foreach($email as $id){
 
            $result = \DB::table('users')->where('id','=' ,$id)->first(); 
             
            $data  = ['program_name' => $program_name, 'date_from'=> $date_from, 'date_to'=>$date_to, 'program_time'=>$program_time,'post'=>$post];
            Mail::to($result->email)->send(new Invite_mail($data));
        }
              return ;  
    }
    
}
