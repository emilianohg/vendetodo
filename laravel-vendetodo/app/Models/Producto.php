<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $table = 'productos';
  protected $primaryKey = 'producto_id';

  protected $fillable = [
    'nombre',
    'descripcion',
    'precio',
    'marca_id',
    'largo',
    'ancho',
    'alto',
    'status',
    'imagen_url'
  ];

  public function marca()
  {
    return $this->belongsTo(Marca::class,'marca_id','marca_id');
  }

  public $timestamps = true;

}
