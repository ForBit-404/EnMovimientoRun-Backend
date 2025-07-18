<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Student Model
 * @property date $fecha_registro
 * @property string $objetivo
 * @property boolean $estado_sit_actual
 * @property boolean $estado_pago
 * @property string $edad
 * @property string $profesion
 * @property string $dias_gym
 * @property string $dia_descanso
 * @property string $actividad_complementaria
 * @property string $km_objetivo
 * @property string $proximo_objetivo
 * @property string $horario_entrenamiento
 * @property string $tiene_reloj_garmin
 * @property string $condiciones_medicas
 * @property date $fecha_ultima_ergonometria
 * @property string $habitos_correr
 */

class Student extends Model{
    protected $fillable = [
        'id','fecha_registro', 'objetivo', 'estado_sit_actual', 
        'estado_pago', 'edad', 'profesion', 'dias_gym', 'dia_descanso',
        'actividad_complementaria', 'km_objetivo', 'proximo_objetivo',
        'horario_entrenamiento', 'tiene_reloj_garmin', 
        'condiciones_medicas', 'fecha_ultima_ergonometria', 
        'habitos_correr'
    ];
    protected $table = 'alumno';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $hidden = ['password'];
    protected $casts = [
        'id' => 'integer',
        'fecha_registro' => 'date',
        'estado_sit_actual' => 'boolean',
        'estado_pago' => 'boolean',
        'edad' => 'string',
        'profesion' => 'string',
        'dias_gym' => 'string',
        'dia_descanso' => 'string',
        'actividad_complementaria' => 'string',
        'km_objetivo' => 'string',
        'proximo_objetivo' => 'string',
        'horario_entrenamiento' => 'string',
        'tiene_reloj_garmin' => 'boolean',
        'condiciones_medicas' => 'string',
        'fecha_ultima_ergonometria' => 'date',
        'habitos_correr' => 'string'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function pagos(){
        return $this->hasMany(Pay::class, 'id_alumno', 'id');
    }

}