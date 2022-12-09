<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AlmacenSeeder::class,
            MetodosPagoSeeder::class,
            EstadosYMunicipiosSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            ProductosSeeder::class,
            ProveedoresSeeder::class,
            LotesSeeder::class,
            InicializarAlmacenSeeder::class,
        ]);
    }
}
