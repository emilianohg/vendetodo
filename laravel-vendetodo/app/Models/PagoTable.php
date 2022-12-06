<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoTable extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $primaryKey = 'pago_id';

    protected $fillable = [
        'pago_id',
        'metodo_pago_id',
        'referencia',
        'fecha',
    ];

    public $timestamps = false;

    public function metodoPago() {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id', 'metodo_pago_id');
    }

}
