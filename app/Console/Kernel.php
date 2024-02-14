<?php

namespace App\Console;

use App\Console\Commands\CheckWithdrawTransaction;
use App\Console\Commands\WithdrawEveryMonth;
use App\Console\Commands\WithdrawEveryWeek;
use App\Console\Commands\WithdrawEvery3Days;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendNoti;
use App\Console\Commands\SendReportForEpay;
use App\Console\Commands\CalculateExchangeRate;
use App\Console\Commands\SendReportPaymentCircleForEpay;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendNoti::class,
        WithdrawEveryWeek::class,
        WithdrawEveryMonth::class,
        // CheckWithdrawTransaction::class,
        WithdrawEvery3Days::class,
        SendReportForEpay::class,
        CalculateExchangeRate::class,
        SendReportPaymentCircleForEpay::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command("SendNoti")
            ->everyMinute();
        $schedule
            ->command("WithdrawEveryWeek")
            ->weeklyOn(1, '00:00');
        $schedule
            ->command("WithdrawEveryMonth")
            ->monthlyOn(5,'00:00');
        $schedule
            ->command("WithdrawEvery3Days")
            ->cron('0 0 1-31/3 * *');
        // $schedule
        //     ->command("CheckWithdrawTransaction")
        //     ->everyFiveMinutes();
        $schedule
            ->command("SendReportForEpay --type=daily")
            ->dailyAt('23:59');
        $schedule
            ->command("SendReportForEpay --type=weekly")
            ->weeklyOn(1, '00:00');
        $schedule
            ->command("SendReportForEpay --type=monthly")
            ->monthlyOn(5,'00:00');
        $schedule
            ->command("CalculateExchangeRate")
            ->everyMinute();
        $schedule
            ->command("SendReportPaymentCircleForEpay --type=weekly")
            ->weeklyOn(1, '00:00');
        $schedule
            ->command("SendReportPaymentCircleForEpay --type=monthly")
            ->monthlyOn(5,'00:00');
        $schedule
            ->command("SendReportPaymentCircleForEpay --type=every3Days")
            ->cron('0 0 1-31/3 * *');
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
