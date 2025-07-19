<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class File extends Model {
    protected $table = 'archivo';
    protected $fillable = [
        'nombre', 
        'tipo', 
        'size', 
        'path'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function getSizeInKbAttribute() {
        return round($this->tamano / 1024, 2);
    }
}