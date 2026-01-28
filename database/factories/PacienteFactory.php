<?php

namespace Database\Factories;

use App\Models\Clinica;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->safeEmail(),
            'telefone' => fake()->phoneNumber(),
            'aniversario' => fake()->date('Y-m-d'),
        ];
    }

    public function paraClinica(Clinica $clinica)
    {
        return $this->state(fn () => [
            'clinica_id' => $clinica->id,
        ]);
    }
}
