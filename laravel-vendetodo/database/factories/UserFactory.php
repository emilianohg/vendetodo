<?php

namespace Database\Factories;

use App\Models\Direccion;
use App\Models\User;
use Faker\Provider\sv_SE\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'rol_id' => 5, // Cliente
        ];
    }

  public function configure()
  {
    $totalMunicipios = DB::table('municipios')->count();

    return $this->afterCreating(function (User $user) use ($totalMunicipios) {

      Direccion::factory()
        ->count(rand(1, 3))
        ->state([
          'usuario_id' => $user->usuario_id,
          'municipio_id' => rand(1, $totalMunicipios),
        ])
        ->create();

    });
  }
}
