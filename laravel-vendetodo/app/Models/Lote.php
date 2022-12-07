<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
  use HasFactory;
  protected $table = 'lotes';
  protected $primaryKey = 'lote_id';

  protected $fillable = [
    'lote_id',
    'proveedor_id',
    'producto_id',
    'cantidad',
    'fecha',
  ];

  public function proveedor()
  {
    return $this->belongsTo(Proveedor::class, 'proveedor_id', 'proveedor_id');
  }

  public function producto()
  {
    return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
  }
}
