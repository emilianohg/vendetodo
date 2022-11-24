<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Rol::query()->updateOrCreate(['rol_id' => 1], ['rol_id' => 1, 'nombre' => 'administrador']);
        Rol::query()->updateOrCreate(['rol_id' => 2], ['rol_id' => 2, 'nombre' => 'surtidor']);
        Rol::query()->updateOrCreate(['rol_id' => 3], ['rol_id' => 3, 'nombre' => 'almacenista']);
        Rol::query()->updateOrCreate(['rol_id' => 4], ['rol_id' => 4, 'nombre' => 'encargado de estante']);
        Rol::query()->updateOrCreate(['rol_id' => 5], ['rol_id' => 5, 'nombre' => 'cliente']);
    }
}
