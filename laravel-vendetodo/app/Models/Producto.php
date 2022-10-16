<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $table = 'productos';

  protected $fillable = [
    'nombre',
    'descripcion',
    'precio',
    'marca_id',
    'largo',
    'ancho',
    'alto',
    'imagen_url'
  ];

  public function marca()
  {
    return $this->belongsTo(Marca::class,'marca_id','id');
  }

  public $timestamps = true;

}
