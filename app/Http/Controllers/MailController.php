<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Testmail;

Use Mail;

use App\Http\Requests;

class MailController extends Controller
{
    //

    function send_email(Request $request){


      $request->validate([
        'get_emp1' =>'required',
        'emp_design' => 'required',
    ]);

        $email = $request->emp_email;
        $data  = ['message' => 'Please fill the form given below'];
        Mail::to($email)->send(new Testmail($data));

        return redirect('dashboard');

      }

     
}
