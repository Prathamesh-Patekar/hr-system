<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $program;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($program)
    {
        //
        $this->program = $program;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $program= $this->program;

        $address  = 'prathamesh.patekar@techsevin.com';
        $subject  = 'Today lecture mail';
        $name  = 'Prathamesh';
        return  $this->view('emails.reminder_mail',compact('program'))
        ->from($address, $name)
        // ->cc($address, $name)
        // ->bcc($address, $name)
        // ->replyTo($address, $name)
        ->subject($subject);

    }
}
