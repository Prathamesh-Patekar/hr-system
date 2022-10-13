<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;

use App\Models\Resignation;
use App\Models\Role;

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
    ->select('users.name as user', 'roles.name as role', 'users.email as email')
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
        return json_encode(array("role" => $item->role, "email" => $item->email));
      }
    }
    return view('hrms.separation.exit-formalities');
  }
}
