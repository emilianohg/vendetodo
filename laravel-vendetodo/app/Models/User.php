<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol() {
        return $this->belongsTo(Rol::class, 'rol_id', 'rol_id');
    }
}
