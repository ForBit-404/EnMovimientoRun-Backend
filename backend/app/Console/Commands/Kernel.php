<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel{
    protected $commands = [
        // Acá podés registrar tus comandos personalizados (opcional)
    ];

    protected function schedule(Schedule $schedule)
    {
        // Acá registrás los comandos programados
        $schedule->command('verificar:estado-pago')->dailyAt('00:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
