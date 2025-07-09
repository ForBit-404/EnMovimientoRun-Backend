<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Pay;
use Carbon\Carbon;

/**
 * Comando para verificar el estado de pago de los alumnos.
 * Este comando se ejecuta diariamente y actualiza el estado de pago de los alumnos
 * basándose en sus últimos pagos.
 */


class VerificarEstadoPagoAlumnos extends Command{

    protected $signature = 'app:verificar-estado-pago-alumnos';
    protected $description = 'Verifica si los alumnos tienen pagos vencidos y actualiza su estado de pago';

    public function handle(){
        $alumnos = Student::where('estado_sit_actual', 1)->get(); // Solo los activos

        foreach ($alumnos as $alumno) {
            $ultimoPago = Pay::where('id_alumno', $alumno->id)
                            ->orderByDesc('fecha_pago')
                            ->first();

            if ($ultimoPago) {
                $hoy = now()->startOfDay();
                $vencimiento = \Carbon\Carbon::parse($ultimoPago->fecha_vencimiento)->startOfDay();

                // Si ya venció
                if ($hoy->greaterThan($vencimiento)) {
                    $alumno->estado_pago = 0;
                } else {
                    $alumno->estado_pago = 1;
                }
                $alumno->save();
            } else {
                // Nunca pagó → está en deuda
                $alumno->estado_pago = 0;
                $alumno->save();
            }
        }

        $this->info('Estados de pago actualizados correctamente.');
    }

}
