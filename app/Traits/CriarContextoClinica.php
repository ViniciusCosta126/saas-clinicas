<?php

namespace App\Traits;

use App\Models\Clinica;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\User;

trait CriarContextoClinica
{
    protected Clinica $clinica;
    protected User $user;
    protected Profissional $profissional;
    protected Paciente $paciente;

    protected function criarContextoClinica(): void
    {
        $this->clinica = Clinica::factory()->create();

        $this->user = User::factory()->paraClinica($this->clinica)->create();

        $this->actingAs($this->user);

        $this->profissional = Profissional::factory()
            ->paraClinica($this->clinica, $this->user)
            ->create();

        $this->paciente = Paciente::factory()
            ->paraClinica($this->clinica)
            ->create();
    }
}