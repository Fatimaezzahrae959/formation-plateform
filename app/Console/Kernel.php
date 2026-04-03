<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Utiliser votre commande existante reminder:sessions
        $schedule->command('reminder:sessions')->dailyAt('09:00');

        // Utiliser votre commande existante sessions:archive
        $schedule->command('sessions:archive')->daily();

        // Optionnel : rapport hebdomadaire
        $schedule->command('report:weekly')->weeklyOn(1, '08:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}