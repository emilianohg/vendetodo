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
        'usuario_id',
        'nombre',
        'email',
        'password',
        'rol_id',
        'metodo_pago_id',
        'direccion_id',
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

    public function metodo_pago() {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id', 'metodo_pago_id');
    }

    public function direccion() {
        return $this->belongsTo(Direccion::class, 'direccion_id', 'direccion_id')
            ->select([
                'direcciones.*',
                'estados.nombre as estado',
                'municipios.nombre as municipio',
            ])
            ->where('status', '=', 'activa')
            ->join('estados', 'direcciones.estado_id', '=', 'estados.estado_id')
            ->join('municipios', function ($join) {
                $join->on('direcciones.estado_id', '=', 'estados.estado_id')
                    ->on('direcciones.municipio_id', '=', 'municipios.municipio_id');
            });
    }

    public function direcciones() {
        return $this->hasMany(Direccion::class, 'usuario_id', 'usuario_id')
            ->select([
                'direcciones.*',
                'estados.nombre as estado',
                'municipios.nombre as municipio',
            ])
            ->where('status', '=', 'activa')
            ->join('estados', 'direcciones.estado_id', '=', 'estados.estado_id')
            ->join('municipios', function ($join) {
                $join->on('direcciones.estado_id', '=', 'municipios.estado_id')
                    ->on('direcciones.municipio_id', '=', 'municipios.municipio_id');
            });
    }
}
