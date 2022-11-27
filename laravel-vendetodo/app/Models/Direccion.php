<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';
    protected $primaryKey = 'direccion_id';

    protected $fillable = [
      'direccion_id',
      'colonia',
      'calle',
      'numero_ext',
      'codigo_postal',
      'usuario_id',
      'municipio_id',
      'status',
    ];

    protected $hidden = [];

    public function usuario()
    {
      return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
    }

    public $timestamps = false;
}
