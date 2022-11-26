<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    
      protected $table = 'metodos_pago';
      protected $primaryKey = 'metodo_pago_id';
    
      protected $fillable = [
        'metodo_pago_id',
        'nombre',
      ];

      public $timestamps = false;

}
