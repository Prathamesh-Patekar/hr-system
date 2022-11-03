<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Testmail;
use Illuminate\Support\Facades\Route;



Use Mail;

use App\Http\Requests;

class MailController extends Controller
{
    //

    function send_email(Request $request){

      Route::getFacadeRoot()->current()->uri();
      //get current full url
      $url = url('');

      $request->validate([
        'get_emp1' =>'required',
        'emp_design' => 'required',
    ]);

        $email = $request->emp_email;
        if($email != ""){
          $id = md5($request->emp_id);

          $data  = ['message' => 'Please  fill the form given below '. $url.'/form/'.$id ];
          Mail::to($email)->send(new Testmail($data));
  
          \Session::flash('flash_message', 'successfully send!');
          return redirect('/exit-formalities');

        }
        else{
          \Session::flash('flash_message', 'already send or incorrect data!');
          return redirect('/exit-formalities');
        }

       

      }
    
}
