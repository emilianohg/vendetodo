<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenTable extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden';

    protected $fillable = [
        'orden_id',
        'producto_id',
        'proveedor_id',
        'cantidad',
        'precio',
    ];

    public $timestamps = false;

    public function orden() {
        return $this->belongsTo(OrdenTable::class, 'orden_id', 'orden_id');
    }

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
    }
}
