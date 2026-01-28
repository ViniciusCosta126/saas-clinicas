<?php

namespace Tests\Feature\Agendamento;

use App\Actions\Agendamento\CriarAgendamento;
use App\Enums\StatusAgendamento;
use App\Exceptions\CriarAgendamentoException;
use App\Models\Agendamento;
use App\Models\Clinica;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CriarAgendamentoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function cria_agendamento_com_status_agendado()
    {
        $clinica = Clinica::factory()->create();

        $user = User::factory()->paraClinica($clinica)->create();

        $this->actingAs($user);

        $profissional = Profissional::factory()
            ->paraClinica($clinica, $user)
            ->create();

        $paciente = Paciente::factory()
            ->paraClinica($clinica)
            ->create();

        $action = new CriarAgendamento();

        $agendamento = $action->execute([
            'profissional_id' => $profissional->id,
            'paciente_id' => $paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '10:00',
            'horario_fim'=>"11:00",
        ]);

        $this->assertDatabaseHas('agendamentos', [
            'id' => $agendamento->id,
            'status' => StatusAgendamento::AGENDADO->value
        ]);
    }

    /**
     * Summary of valida_regra_de_conflito_de_horarios
     * @test
     */
    public function nao_deve_permitir_dois_agendamentos_no_mesmo_horario_para_o_profissional()
    {
        $clinica = Clinica::factory()->create();

        $user = User::factory()->paraClinica($clinica)->create();

        $this->actingAs($user);

        $profissional = Profissional::factory()->paraClinica($clinica, $user)->create();

        $paciente1 = Paciente::factory()->paraClinica($clinica)->create();
        $paciente2 = Paciente::factory()->paraClinica($clinica)->create();

        Agendamento::create([
            'clinica_id' => $clinica->id,
            'profissional_id' => $profissional->id,
            'paciente_id' => $paciente1->id,
            'data' => now(),
            'horario_inicio' => '10:00',
            'horario_fim'=>"11:00",
            'status' => StatusAgendamento::AGENDADO->value,
        ]);

        $this->expectException(CriarAgendamentoException::class);
        (new CriarAgendamento())->execute([
            'profissional_id' => $profissional->id,
            'paciente_id' => $paciente2->id,
            'data' => now(),
            'horario_inicio' => '10:00',
            'horario_fim'=>"11:00",
        ]);
    }
}
