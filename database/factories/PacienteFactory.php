<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Paciente;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'usuario_id' => 1, // Esto se sobreescribe en el test
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'ci' => $this->faker->unique()->numerify('########'),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2005-01-01'),
            'telefono' => $this->faker->numerify('7########'),
            'direccion' => $this->faker->address(),
            'foto' => 'default.jpg',
            'genero' => $this->faker->randomElement(['Masculino','Femenino','Otro']),
        ];
    }
}


