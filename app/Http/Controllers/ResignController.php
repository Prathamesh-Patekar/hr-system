<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use Form;
use Session;
use App\Models\Resignation;
use App\Models\Role;
use App\Models\Employee_form;

Use Illuminate\Support\Facades\DB;

class ResignController extends Controller
{
    //
    public function addresign() {
		$roles = Role::get();

		return view('hrms.separation.resign',compact('roles'));
	}

	public function formalities() {
		$roles = Role::get();

		return view('hrms.separation.formalities',compact('roles'));
	}

  //   public function autocompleteSearch(Request $request)
  //   {
  //       $query = $request->get('query');
  //       $filterResult = Employee::where('name', 'LIKE', '%'. $query. '%')->get();
  //       return response()->json($filterResult);
  // } 

  public function searching(Request $request){
    $roles = Role::get();

    if($request->ajax()){
      $data = Employee::where('name', 'LIKE',  $request->name. '%')->get();
      $output = "";
      if(count($data) > 0){
        $output = '<ul class="list-group" style="display:block;position: relative, z-index: 1;"> ';

        foreach($data as $row){
          $output .= '<li class="list-group-item">'.$row->name.'</li>';
        }
        $output .= '</ul> ';
      }
      else{
        $output .= '<li class="list-group-item">not found</li>';
      }
    return $output;
    }

    return view('hrms.separation.resign');

  }

  public function search_employee(Request $request){
    $roles = Role::get();

    if($request->ajax()){
      $data = Employee::where('name', 'LIKE',  $request->name. '%')->get();

      foreach($data as $item){
        $id = $item->id;
      }
     
      if($id != "")
      {
        $data1 = Resignation::where('user_id', 'LIKE', $id. '%')->get(); 

        $output = "";
          if(count($data1) > 0){
            $output = '<ul class="list-group" style="display:block;position: relative, z-index: 1;"> ';
    
            foreach($data as $row){
              $output .= '<li class="list-group-item">'.$row->name.'</li>';
            }
            $output .= '</ul> ';
          }
          else{
            $output .= '<li class="list-group-item">not found</li>';
          }
        return $output;

      }
    }

    return view('hrms.separation.resign');

  }
 

  function processresign(Request $request)
  {

    $result = DB::table('employees')
    // ->select('*')
    ->where('name', '=', $request->get_emp)
    ->get();

    foreach($result as $item){
      $id = $item->id;
    }

    $request->validate([
      'get_emp' =>'required',
      'dor' =>'required',
      'doj' => 'required',
      'notice_date' => 'required',
      'full_final' => 'required',
  ]);

    $resign = new Resignation();
		$resign->user_id = $id;
		$resign->date_of_resignation = date_format(date_create($request->dor), 'Y-m-d');
    $resign->notice_period = $request->notice_date;
		$resign->last_working_day = date_format(date_create($request->doj), 'Y-m-d');
    $resign->full_final = $request->full_final;
		$resign->save();
    return redirect('dashboard');

  }


  function design_table(Request $request)
  {
    $data1 =  DB::table('roles')
    ->select('users.name as user','users.id as id' ,'roles.name as role', 'users.email as email')
    ->join('user_roles', 'roles.id', '=', 'user_roles.role_id')
    ->join('users', 'users.id', '=', 'user_roles.user_id')
    ->get(); 

    if($request->ajax())
    {
      $data = $request->name;
    }

    foreach($data1 as $item)
    {
      $name = $item->user;
      if($name ==  $data)
      {
        return json_encode(array("id" => $item->id ,"role" => $item->role, "email" => $item->email,));
      }
    }
    return view('hrms.separation.exit-formalities');
  }

  function form_table($id, Request $request){

    $var = Session::get('user');

    $value = md5(Session::get('user'));

    if($value == $id)
    {
      $entry = Employee_form::where('user_id', 'LIKE', $var)->get(); 
      if(count($entry) == 0)
      {
        $data =  DB::table('resignations')
        ->select('users.name as user','resignations.*')
        ->join('users', 'users.id', '=', 'resignations.user_id')
        ->where('user_id',"=", $var)
        ->get();

        $json  = json_encode($data);
        $array = json_decode($json, true);
      
        foreach($array as $item1){
          $msg = $item1;
        }
        return view('hrms.separation.form', ['data'=>$msg]);
      }
      else{
        return "<div style= height:100%;><h1 style>You have already fill the form</h1></div>";
      }
    }

    return "<h1>You can't access this page</h1>";

  }

  function save_form(Request $request)
  {
    $result = new Employee_form();

    foreach($request->all() as $input_key => $input_value){ // split input one by one

      if($request->get_emp != $input_value && '_token' !=  $input_key){
        $collect[] = array( //customised inputs
        $input_key => $input_value
        );
      }
    } 
    $data = json_encode($collect);

    $table = DB::table('employees')
    ->where('name', '=', $request->get_emp)
    ->get();

    foreach($table as $item){
      $id = $item->id;
    }

    $result->user_id = $id;
    $result->question_answers = $data;
    $result->save();
    return view("/");

  }

  function show_exit_forms(){

    $emps = Resignation::with('employee','employee_form')->paginate(15);

    $column = '';
		$string = '';

		return view('hrms.separation.exit_forms', compact('emps', 'column', 'string'));
  }

  function resignation_form($id){ 

    $data = Resignation::with('employee','employee_form')->where('user_id', $id)->get();

    return view('hrms.separation.show_form',['datas'=>$data]);
  }
  
}
