<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {

      User::factory()
        ->state([
          'rol_id' => 1,
          'nombre' => 'Administrador',
          'email' => 'admin@example.com',
          'password' => bcrypt('password'),
        ])
        ->create();

      User::factory()
        ->state([
          'rol_id' => 2,
          'nombre' => 'Surtidor',
          'email' => 'surtidor@example.com',
          'password' => bcrypt('password'),
        ])
        ->create();

      User::factory()
        ->state([
          'rol_id' => 3,
          'nombre' => 'Almacenista',
          'email' => 'almacenista@example.com',
          'password' => bcrypt('password'),
        ])
        ->create();

        // Administradores
        User::factory()->count(2)
            ->state(['rol_id' => 1])
            ->create();

        $numEstantes = config('almacen.numero_estantes', 20);
        $numSurtidores = floor($numEstantes / 5);

        // Surtidores
        $usuariosSurtidores = User::factory()->count($numSurtidores)
            ->state(['rol_id' => 2])
            ->create();

        foreach ($usuariosSurtidores as $i => $usuarioSurtidor) {
          $estanteId = $i + 1;

          if ($estanteId > $numEstantes) {
            break;
          }

          DB::table('surtidores')->insert([
            'surtidor_id' => $usuarioSurtidor->usuario_id,
            'estante_id' => $i + 1,
          ]);
        }

        // Almacenista
        User::factory()->count(1)
            ->state(['rol_id' => 3])
            ->create();

        $numEstantes = config('almacen.numero_estantes', 20);
        // Encargado de estante
        User::factory()->count($numEstantes)
            ->state(['rol_id' => 4])
            ->create()
            ->each(function ($usuario, $key) {
                DB::table('encargados_estantes')->insert([
                    'estante_id' => $key + 1,
                    'usuario_id' => $usuario->usuario_id,
                ]);
            });

        // Clientes
        User::factory()->count(200)
            ->state(['rol_id' => 5])
            ->create();
    }
}
