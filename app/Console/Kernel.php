<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // ตั้งค่าให้รันคำสั่งอัปเดต Google Sheets ทุกๆ 1 นาที
        $schedule->command('update:google-sheets')->everyMinute();

        // ตั้งค่าให้ Queue Worker ทำงานทุกๆ 1 นาที
        $schedule->command('queue:work --tries=3')->everyMinute()->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
