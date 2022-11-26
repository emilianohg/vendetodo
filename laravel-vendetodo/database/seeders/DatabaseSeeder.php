<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            ProductosSeeder::class,
            ProveedoresSeeder::class,
        ]);
    }
}
