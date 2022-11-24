<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->state([
                'rol_id' => 1,
                'nombre' => 'Administrador',
                'email' => 'admin@example.com',
            ])
            ->create();

        User::factory()
            ->state([
                'rol_id' => 2,
                'nombre' => 'Surtidor',
                'email' => 'surtidor@example.com',
            ])
            ->create();

        User::factory()
            ->state([
                'rol_id' => 3,
                'nombre' => 'Almacenista',
                'email' => 'almacenista@example.com',
            ])
            ->create();

        // Administradores
        User::factory()->count(10)
            ->state(['rol_id' => 1])
            ->create();

        // Surtidores
        User::factory()->count(20)
            ->state(['rol_id' => 2])
            ->create();

        // Almacenista
        User::factory()->count(1)
            ->state(['rol_id' => 3])
            ->create();

        // Encargado de estante
        User::factory()->count(20)
            ->state(['rol_id' => 4])
            ->create();

        // Clientes
        User::factory()->count(200)
            ->state(['rol_id' => 5])
            ->create();
    }
}
