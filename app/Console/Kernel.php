<?php

namespace App\Console;

use App\Events\SmsEvent;
use App\Invoice;
use Event;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        {
            $schedule->call(function(){

                $usersArray = [];
                $invoices = Invoice::where('is_paid', '0')
                    ->where('is_sent','0')
                    ->where('last_pay_day', '<=' , Carbon::now()->addDay(1))->get();

                foreach ($invoices as $invoice) {
                    $invoice->is_sent = 1;
                    $invoice->save();
                    $usersArray[$invoice->user->id] = $invoice->user;
                }
                foreach ($usersArray as $user) {
                    \Event::fire(new SmsEvent($user));
                }
                return true;
            })->everyFiveMinutes();
        }
    }
}
