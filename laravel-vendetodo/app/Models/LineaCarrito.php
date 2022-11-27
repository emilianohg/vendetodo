<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineaCarrito extends Model
{
    protected $table = 'lineas_carrito';
    protected $primaryKey = 'linea_carrito_id';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'proveedor_id',
        'cantidad'
      ];

    public function usuario()
    {
        return $this->belongsTo(User::class,'usuario_id','usuario_id');
    }

    public function producto()
    {
        return $this->belongsTo(producto::class,'producto_id','producto_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(proveedor::class,'proveedor_id','proveedor_id');
    }

  public $timestamps = false;
}
