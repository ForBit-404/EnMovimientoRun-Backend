<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $table = 'usuario';
    protected $fillable = [
        'nombre', 
        'usuario', 
        'email', 
        'password', 
        'apellido', 
        'sexo', 
        'dni', 
        'fecha_nacimiento',
        'telefono'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $hidden = ['password'];
    protected $appends = ['edad'];

    // Mutator para encriptar password al asignarlo
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function admin(){
        return $this->hasOne(Admin::class, 'id', 'id');
    }
    
    public function getEdadAttribute(){
        return Carbon::parse($this->fecha_nacimiento)->age;
    }
}