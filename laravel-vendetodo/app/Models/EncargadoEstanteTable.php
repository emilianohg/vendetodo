<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncargadoEstanteTable extends Model
{
  use HasFactory;

  protected $table = 'encargados_estantes';

  protected $fillable = [
    'estante_id',
    'usuario_id',
  ];

  public $timestamps = false;

  public function usuario()
  {
      return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
  }
}
