<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Almacen extends Model
{
      protected $table = 'almacen';

      protected $fillable = [
        'estante_id',
        'seccion_id',
        'producto_id',
      ];

      public $timestamps = false;

}
