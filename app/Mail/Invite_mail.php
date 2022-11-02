<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invite_mail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address  = 'prathamesh.patekar@techsevin.com';
        $subject  = 'Invite Mail';
        $name  = 'Prathamesh';
        return  $this->view('emails.invite')
        ->from($address, $name)
        // ->cc($address, $name)
        // ->bcc($address, $name)
        // ->replyTo($address, $name)
        ->subject($subject)
        ->with([ 'test_message' =>  $this->data ]);
        \Log::info($test_message);

    }
}
