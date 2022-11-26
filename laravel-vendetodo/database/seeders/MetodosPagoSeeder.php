<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Seeder;

class MetodosPagoSeeder extends Seeder
{
    public function run()
    {
      MetodoPago::query()->updateOrCreate(['metodo_pago_id' => 1], ['metodo_pago_id' => 1, 'nombre' => 'PayPal']);
      MetodoPago::query()->updateOrCreate(['metodo_pago_id' => 2], ['metodo_pago_id' => 2, 'nombre' => 'Tarjeta de credito o debito']);
    }
}
