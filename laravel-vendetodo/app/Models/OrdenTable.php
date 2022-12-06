<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenTable extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $primaryKey = 'orden_id';

    protected $fillable = [
        'orden_id',
        'usuario_id',
        'surtidor_id',
        'status',
        'pago_id',
        'fecha_creacion',
        'direccion_envio_id',
    ];

    public $timestamps = false;

    public function detalle() {
        return $this->hasMany(DetalleOrdenTable::class, 'orden_id', 'orden_id');
    }

    public function pago() {
        return $this->belongsTo(PagoTable::class, 'pago_id', 'pago_id');
    }

    public function cliente() {
        return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
    }

    public function surtidor() {
        return $this->belongsTo(User::class, 'surtidor_id', 'usuario_id');
    }

    public function direccion() {
        return $this->belongsTo(Direccion::class, 'direccion_envio_id', 'direccion_id')
            ->select([
                'direcciones.*',
                'estados.nombre as estado',
                'municipios.nombre as municipio',
            ])
            ->join('estados', 'direcciones.estado_id', '=', 'estados.estado_id')
            ->join('municipios', 'direcciones.municipio_id', '=', 'municipios.municipio_id');
    }
}
