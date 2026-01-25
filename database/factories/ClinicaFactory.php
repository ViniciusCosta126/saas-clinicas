<?php

namespace Database\Factories;

use App\Models\Clinica;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinica>
 */
class ClinicaFactory extends Factory
{
    protected $model = Clinica::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            "nome_clinica" => fake()->company(),
            "nome_responsavel" => fake()->name(),
            "email" => fake()->companyEmail(),
            "telefone" => fake()->phoneNumber(),
            'preco_min_consulta' => 50,
            'preco_max_consulta' => 1000,
        ];
    }
}
