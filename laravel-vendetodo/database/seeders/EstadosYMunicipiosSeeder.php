<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class EstadosYMunicipiosSeeder extends Seeder
{
    public function run()
    {
      $csvStates = Reader::createFromPath(storage_path('csv/states.csv'));
      $csvStates->setHeaderOffset(0);

      foreach ($csvStates->getRecords() as $record) {
        DB::table('estados')->insert([
          'estado_id' => $record['state_id'],
          'nombre' => $record['name'],
        ]);
      }


      $csvMunicipalities = Reader::createFromPath(storage_path('csv/municipalities.csv'));
      $csvMunicipalities->setHeaderOffset(0);

      foreach ($csvMunicipalities->getRecords() as $record) {
        DB::table('municipios')->insert([
          'estado_id' => $record['state_id'],
          'municipio_id' => $record['municipality_id'],
          'nombre' => $record['name'],
        ]);
      }
    }
}
