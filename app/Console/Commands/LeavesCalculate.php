<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Holiday_employee;

class LeavesCalculate extends Command
{
    public $mailer;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LeaveCalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $data = Holiday_employee::get();
		foreach($data as $item){

			$balance =  $item->allow_leaves - $item->taken_leaves;
			if($balance >  0 && $balance <= 45){
				$value = $balance;
			}
			elseif($balance <=  0){
				$value = 0;
			}elseif($balance > 45){
				$value = 45;
			}

			\DB::table('holiday_employees')->where('user_id', $item->user_id)->update(['allow_leaves' => $value, 'taken_leaves' => 0]);

		}
		
		return;

        

    }

  
}
