<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Admin Model
 * @property boolean $isAdmin
*/

class Admin extends Model {
    protected $fillable = ['id', 'isAdmin'];
    protected $table = 'administrador';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'integer',
        'isAdmin' => 'boolean'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'id');
    }
}