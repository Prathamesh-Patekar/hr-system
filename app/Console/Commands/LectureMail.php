<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;
use App\Mail\ReminderMail;
use App\User;
use App\ScheduleLecture;
use Carbon\Carbon;


class LectureMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ReminderMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
 
        $today= Carbon::now()->toDateString();
       
                $schedule = \DB::table('users')->select('users.name', 'users.email', 'schedule_lectures.date_on', 'training_programs.name as program_name')
                ->JOIN('training_invites','users.id', '=', 'training_invites.user_id')
                ->JOIN('schedule_lectures','training_invites.program_id','=','schedule_lectures.program_id')
                ->JOIN('training_programs', 'training_invites.program_id','=','training_programs.id')
                ->where('date_on','=', $today)
                ->get();

                \Log::info($schedule);

                foreach($schedule as $items){
                    $email = $items->email;
                    $program = $items->program_name;

                    Mail::to($email)->send(new ReminderMail($program));
            
            }

  
        return 0;

    }
}
