<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AlmacenTable extends Model
{
  protected $table = 'almacen';

  protected $fillable = [
    'estante_id',
    'seccion_id',
    'producto_id',
  ];

  public $timestamps = false;

  public function producto()
  {
    return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
  }
}
