<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $users;
    public $holidays;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users,$holidays)
    {
        $this->users = $users;
        $this->holidays = $holidays;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address  = 'prathamesh.patekar@techsevin.com';
        $name  = 'Hr';
        $users=$this->users->values() ;
        $holidays= $this->holidays;
		// 			\Log::info(get_class_methods($holidays));
        foreach ($holidays as $holiday) {
			$occasion=$holiday['occasion'];
            $date=$holiday['date_from'];
        }
        $subject  = 'Holiday on '.$date .' ,occasion of '.$occasion;

        return  $this->view('hrms.leave.demo',compact('occasion','date'))
        ->from($address, $name)
        ->to($users)
        // ->cc($address, $name)
        // ->bcc($address, $name)
        // ->replyTo($address, $name)
        ->subject($subject);
        // ->with([ 'test_message' =>  $this->data['message'] ]);
        // return $this->view('hrms.leave.demo');
    
    }
}
