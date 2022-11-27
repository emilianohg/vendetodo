<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlmacenSeeder extends Seeder
{
    public function run()
    {
        $numEstantes = config('almacen.numero_estantes', 20);
        $numSecciones = config('almacen.numero_secciones', 30);

        $data = [];

        for ($i = 1; $i <= $numEstantes; $i++) {
          for ($j = 1; $j <= $numSecciones; $j++) {
            $data[] = [
              'estante_id' => $i,
              'seccion_id' => $j,
              'producto_id' => null,
            ];
          }
        }

        DB::table('almacen')->insert($data);

    }
}
