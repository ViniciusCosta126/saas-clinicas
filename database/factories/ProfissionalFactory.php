<?php

namespace Database\Factories;

use App\Models\Clinica;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfissionalFactory extends Factory
{
    protected $model = Profissional::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'especialidade' => fake()->jobTitle(),
            'preco_sessao' => fake()->numberBetween(100, 500),
        ];
    }

    public function paraClinica(Clinica $clinica)
    {
        return $this->state(function () use ($clinica) {

            $user = User::factory()
                ->paraClinica($clinica)
                ->create();

            return [
                'clinica_id' => $clinica->id,
                'user_id' => $user->id,
            ];
        });
    }
}
