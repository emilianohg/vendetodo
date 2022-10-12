<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Marca extends Model
{
    
      protected $table = 'marcas';
    
      protected $fillable = [
        'nombre'
      ];

      public function productos()
      {
        return $this->hasMany(Producto::class,'marca_id','id');
      }

}
