<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model{
    protected $table = 'semana';

    protected $fillable = [
        'id_historial_entreno',
        'dia',
        'fecha',
        'cant_km',
        'ritmo',
        'comentario',
        'tiempo'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id';
}
