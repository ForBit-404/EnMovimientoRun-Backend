<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTraining extends Model{
    protected $table = 'historial_entreno';

    protected $fillable = [
        'descripcion',
        'fecha_inicio',
    ];

    public $timestamps = false;
    protected $primaryKey = 'id';
}
