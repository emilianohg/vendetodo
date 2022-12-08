<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesPreasignadasTable extends Model
{
    use HasFactory;

    protected $table = 'ordenes_preasignadas';

    protected $fillable = [
        'orden_id',
        'surtidor_id',
        'intento',
        'fecha',
        'status',
    ];

    public $timestamps = false;

    public function orden() {
        return $this->belongsTo(OrdenTable::class, 'orden_id', 'orden_id');
    }
}
