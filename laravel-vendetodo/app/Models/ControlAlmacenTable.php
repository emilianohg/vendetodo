<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAlmacenTable extends Model
{
  use HasFactory;
  protected $table = 'control_almacen';

  protected $fillable = [
    'estante_id',
    'seccion_id',
    'lote_id',
    'cantidad',
    'cantidad_disponible',
    'status',
  ];

  public function lote()
  {
    return $this->belongsTo(Lote::class, 'lote_id', 'lote_id');
  }

  public function producto()
  {
    return $this->belongsTo(Lote::class, 'lote_id', 'lote_id')
      ->select(['productos.*'])
      ->join('productos', 'productos.producto_id', '=', 'lotes.producto_id');
  }
}
