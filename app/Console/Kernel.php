<?php

namespace App\Console;
use App\Models\Holiday;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\ScheduleLecture;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\AutoHolidayNotification::class,
        \App\Console\Commands\Wish::class,
        \App\Console\Commands\LeavesCalculate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:ReminderMail')->dailyAt('10:00');
        $schedule->command('command:LeaveCalculate')->cron('0 7 1 4 *');

        $dateInDatabases=Holiday::select('date_from')->get();

            if ($dateInDatabases->count() > 0) {
                foreach ($dateInDatabases as $dateInDatabase) {
					// \Log::info($dateInDatabase['date_from']);

                $beforeThreeDay = Carbon::parse($dateInDatabase['date_from'])->subDays()->toDateString();
                $schedule->command('command:AutoHolidayNotification')->dailyAt('12:00')->when(function () use ($beforeThreeDay) {
                    return(
                        $beforeThreeDay == Carbon::now()->toDateString()
                    );
                });
            }

        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
