<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProveedorFactory extends Factory
{
    public function definition()
    {
        return [
            'nombre' => $this->faker->company(),
        ];
    }
}
