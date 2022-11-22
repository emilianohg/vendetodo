<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Marca extends Model
{
    
      protected $table = 'marcas';
      protected $primaryKey = 'marca_id';
    
      protected $fillable = [
        'nombre'
      ];

      public function productos()
      {
        return $this->hasMany(Producto::class,'marca_id','marca_id');
      }

      public $timestamps = false;

}
