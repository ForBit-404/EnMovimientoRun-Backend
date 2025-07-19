<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model{
    protected $table = 'plan_entrenamiento';

    protected $fillable = [
        'id_alumno',
        'id_historial_entrenamiento',
        'nombre',
        'fecha_inicio',
    ];

    public $timestamps = false;
    protected $primaryKey = 'id';
}
