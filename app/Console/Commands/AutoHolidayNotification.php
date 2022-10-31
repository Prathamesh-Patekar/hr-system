<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\DemoMail;
use App\User;
use App\Models\Holiday;
use Carbon\Carbon;




class AutoHolidayNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AutoHolidayNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Holiday Notification';

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

        $users = User::select('email')->get();
					// \Log::info($users);
  
        // if ($users->count() > 0) {
        //     foreach ($users as $user) {
		// 			\Log::info($user);
        //         $data=['data'=>'data cron test'];
                // Mail::send('hrms.leave.demo',$data,function($message){
                //     $message->from('akash.jadhav@techsevin.com')
                //     ->to($user)
                //     ->subject('Cron test');
        
                // });
        //     }
        // }
  
        // return 0;

        $todayAddTwo= Carbon::now()->addDays(2)->toDateString();
					\Log::info($todayAddTwo);

       
                $holidays=Holiday::select('date_from','occasion')->where('date_from',$todayAddTwo)->get();
               
                Mail::send(new DemoMail($users,$holidays));
           
  
        return 0;
       
    }
}
