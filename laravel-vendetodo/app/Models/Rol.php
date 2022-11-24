<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
      protected $table = 'roles';
      protected $primaryKey = 'rol_id';
    
      protected $fillable = [
        'nombre'
      ];

      public function usuarios()
      {
        return $this->hasMany(User::class, 'usuario_id', 'usuario_id');
      }

      public $timestamps = false;

}
