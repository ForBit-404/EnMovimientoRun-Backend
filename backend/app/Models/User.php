<?php

namespace App\Models;

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
        'dni'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $hidden = ['password'];

    // Mutator para encriptar password al asignarlo
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function admin(){
        return $this->hasOne(Admin::class, 'id', 'id');
    }

}
