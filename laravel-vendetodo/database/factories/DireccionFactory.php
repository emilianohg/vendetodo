<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DireccionFactory extends Factory
{
    public function definition()
    {
        return [
          'colonia' => $this->faker->words(3, true),
          'calle' => $this->faker->streetName(),
          'numero_ext' => $this->faker->numberBetween(1, 2500),
          'codigo_postal' => $this->faker->numberBetween(10000, 99999),
          'usuario_id' => 1,
          'municipio_id' => 1,
          'status' => 'activa',
        ];
    }
}
