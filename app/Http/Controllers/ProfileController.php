<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProfileController extends Controller
{
    public function show(){

        $details = Employee::where('user_id', \Auth::user()->id)->with('userrole.role')->first();
        $events = $this->convertToArray(Event::where('date', '>', Carbon::now())->orderBy('date','desc')->take(3)->get());
        $emps = User::with('employee', 'role.role');
        return view('hrms.profile', compact('details','events','emps'));
    }
    public function showData($id){
        $find= Employee::find($id);
		$emps = User::where('id', $id)->with('employee', 'role.role')->find($id);
        // $emp=get_class_methods($emps);
        // return $emps;
        return view('hrms.employee.showdata', compact('find','emps'));

    }

    public function convertToArray($values)
    {
        $result = [];
        foreach($values as $key => $value)
        {
            $result[$key] = $value;
        }
        return $result;
    }
}
