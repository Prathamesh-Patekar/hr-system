<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;

class Wish extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'Techsevin:wishes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'sends an email wishing birthdays/work anniversary';

	/**
	 * Wish constructor.
	 * @param Mailer $mailer
	 */
	public function __construct(Mailer $mailer) {
		$this->mailer = $mailer;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$dateToday = date('Y-m-d');
		$users = \App\Models\Employee::whereRaw("DATE_FORMAT(`date_of_birth`, '%m-%d') != DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();
		$emps = \App\Models\Employee::whereRaw("DATE_FORMAT(`date_of_joining`, '%m-%d') = DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();

		foreach ($users as $user) {
			$this->info('emp id ' . $user->id);
			$this->info('emp user id ' . $user->user_id);
			$this->info($user->user->email);
			//send an email
			if ($user->user->email == 'astik@techsevin.com') {
				$subject = " Happy Birthday $user->name";
				/*$body = "Dear $user->name, <br /> <br /> Techsevin Solution LLP wishes you a very happy birthday. Have fun and enjoy your day.
					            <br /> <br />
					            <img src='http://shetakesontheworld.com/wp-content/uploads/2012/01/shutterstock_59781901.jpg'>
					            <br /><br />
				*/

				$body = 'Dear ' . $user->name . ',<br>
	            We value your special day just as much as we value you. On your birthday, we send you our warmest and most heartfelt wishes.
	            We are thrilled to be able to share this great day with you, and glad to have you as a valuable member of the team. We appreciate everything you’ve done to help us flourish and grow.<br>
	            Our entire corporate family at Techsevin Solution LLP wishes you a very happy birthday and wishes you the best on your special day!
	            <br>
	            Regards,<br>
				Techsevin Solution LLP';
				echo $body . PHP_EOL;
				$mail = $this->mailer->send('hrms.wishes.birthday', ['body' => $body], function ($message) use ($user, $subject) {
					$message->from('astik@techsevin.com', 'Techsevin Solution LLP');

					$message->to($user->user->email, $user->name)->subject($subject);
				});
				echo "<hr /><h1>DEBUG</h1><pre>";
				print_r($mail);
				echo "</pre>";
				echo "=======================================" . PHP_EOL;
			}
		}

		foreach ($emps as $emp) {
			//send an email
			$subject = " Congratulations on Work Anniversary $emp->name";
			$body = "Dear $emp->name, <br /> <br /> Many congratulations for your work anniversary. Wish you loads of success for your future.
            <br /> <br />
            <img src='http://ak.imgag.com/imgag/product/postcards/3397536/550x400xgraphic1.jpg.pagespeed.ic.G_VtKZOtwJ.jpg'>
            <br /><br />
            Best Wishes, <br /><br /> Techsevin Solution LLP ";
			$this->mailer->send('hrms.wishes.anniversary', ['body' => $body], function ($message) use ($emp, $subject) {
				$message->from('hr@techsevin.com', 'Techsevin Solution LLP Pvt Ltd');
				$message->to($emp->user->email, $emp->name)->subject($subject);
			});
		}

	}
}
