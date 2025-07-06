<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

/**
 * Pay Model
 * @property int $id
 * @property int $id_alumno
 * @property date $fecha_pago
 * @property float $monto
 * @property date $fecha_vencimiento
 * @property string $medio_pago
 * @property string $estado
*/

class Pay extends Model {
    protected $fillable = [
        'id_alumno', 'fecha_pago', 'monto', 'fecha_vencimiento', 'medio_pago', 'estado'
    ];
    protected $table = 'pago';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $casts = [
        'id' => 'integer',
        'id_alumno' => 'integer',
        'fecha_pago' => 'date',
        'monto' => 'float',
        'fecha_vencimiento' => 'date',
        'medio_pago' => 'string',
        'estado' => 'string'
    ];

    public function alumno() {
        return $this->belongsTo(Student::class, 'id_alumno', 'id');
    }
}