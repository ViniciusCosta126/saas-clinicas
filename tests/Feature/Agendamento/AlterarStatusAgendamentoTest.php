<?php

namespace Tests\Feature\Agendamento;

use App\Actions\Agendamento\CancelarAgendamento;
use App\Actions\Agendamento\ConcluirAgendamento;
use App\Actions\Agendamento\ConfirmaPresenca;
use App\Actions\Agendamento\CriarAgendamento;
use App\Actions\Agendamento\MarcaFaltaAgendamento;
use App\Enums\StatusAgendamento;
use App\Exceptions\CancelarAgendamentoException;
use App\Exceptions\ConcluirAgendamentoException;
use App\Exceptions\ConfirmaAgendamentoException;
use App\Exceptions\MarcaFaltaAgendamentoException;
use App\Models\Clinica;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\User;
use App\Traits\CriarContextoClinica;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlterarStatusAgendamentoTest extends TestCase
{
    use RefreshDatabase, CriarContextoClinica;

    public function setUp(): void
    {
        parent::setUp();
        $this->criarContextoClinica();
    }
    public function test_deve_alterar_o_status_do_agendamento_para_confirmado_quando_confirmar_presenca()
    {
        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '10:00',
            'horario_fim' => "11:00",
        ]);

        (new ConfirmaPresenca())->execute($agendamento->id);

        $this->assertDatabaseHas('agendamentos', [
            'id' => $agendamento->id,
            'status' => StatusAgendamento::CONFIRMADO->value
        ]);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_alterar_o_status_de_um_agendamento_cancelado()
    {
        Carbon::setTestNow(
            now()->setTime(8, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '14:00',
            'horario_fim' => "15:00",
        ]);

        (new CancelarAgendamento())->execute($agendamento->id);

        $this->expectException(ConfirmaAgendamentoException::class);
        $actionAlteraStatus = new ConfirmaPresenca();
        $actionAlteraStatus->execute($agendamento->id);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_cancelar_um_agendamento_com_menos_de_uma_hora_de_antecedencia()
    {
        Carbon::setTestNow(
            now()->setTime(16, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        $this->expectException(CancelarAgendamentoException::class);
        (new CancelarAgendamento())->execute($agendamento->id);
    }

    public function test_deve_permitir_cancelar_um_agendamento_com_mais_de_uma_hora_de_antecedencia()
    {
        Carbon::setTestNow(
            now()->setTime(15, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new CancelarAgendamento())->execute($agendamento->id);

        $this->assertDatabaseHas('agendamentos', [
            'id' => $agendamento->id,
            'status' => StatusAgendamento::CANCELADO->value
        ]);
    }

    public function test_deve_retornar_uma_exception_caso_nao_tenha_passado_dos_5_minutos_de_tolerancia()
    {
        Carbon::setTestNow(
            now()->setTime(15, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        $this->expectException(MarcaFaltaAgendamentoException::class);
        (new MarcaFaltaAgendamento())->execute($agendamento->id);
    }

    public function test_deve_conseguir_marcar_falta_apos_os_5_minutos_de_tolerancia()
    {
        Carbon::setTestNow(
            now()->setTime(18, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new MarcaFaltaAgendamento())->execute($agendamento->id);
        $this->assertDatabaseHas('agendamentos', [
            'id' => $agendamento->id,
            'status' => StatusAgendamento::NAO_COMPARECEU->value
        ]);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_marcar_falta_para_um_agendamento_cancelado()
    {
        Carbon::setTestNow(
            now()->setTime(15, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new CancelarAgendamento())->execute($agendamento->id);

        $this->expectException(MarcaFaltaAgendamentoException::class);
        (new MarcaFaltaAgendamento())->execute($agendamento->id);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_marcar_falta_para_um_agendamento_concluido()
    {
        Carbon::setTestNow(
            now()->setTime(15, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new ConcluirAgendamento())->execute($agendamento->id);

        $this->expectException(MarcaFaltaAgendamentoException::class);
        (new MarcaFaltaAgendamento())->execute($agendamento->id);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_marcar_falta_para_um_agendamento_que_ja_esta_marcado_como_falta()
    {
        Carbon::setTestNow(
            now()->setTime(18, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new MarcaFaltaAgendamento())->execute($agendamento->id);

        $this->expectException(MarcaFaltaAgendamentoException::class);
        (new MarcaFaltaAgendamento())->execute($agendamento->id);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_marcar_presenca_para_um_agendamento_cancelado()
    {
        Carbon::setTestNow(
            now()->setTime(8, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new CancelarAgendamento())->execute($agendamento->id);

        $this->expectException(ConcluirAgendamentoException::class);
        (new ConcluirAgendamento())->execute($agendamento->id);
    }

    public function test_deve_retornar_uma_exception_ao_tentar_marcar_presenca_para_um_agendamento_que_ja_esta_com_presenca()
    {
        Carbon::setTestNow(
            now()->setTime(8, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new ConcluirAgendamento())->execute($agendamento->id);

        $this->expectException(ConcluirAgendamentoException::class);

        (new ConcluirAgendamento())->execute($agendamento->id);
    }

    public function test_deve_permitir_concluir_um_agendamento_se_o_status_nao_for_cancelado_nem_concluido()
    {
        Carbon::setTestNow(
            now()->setTime(8, 30)
        );

        $agendamento = (new CriarAgendamento())->execute([
            'profissional_id' => $this->profissional->id,
            'paciente_id' => $this->paciente->id,
            'data' => now()->toDateString(),
            'horario_inicio' => '17:00',
            'horario_fim' => "18:00",
        ]);

        (new ConcluirAgendamento())->execute($agendamento->id);

        $this->assertDatabaseHas('agendamentos', [
            'id' => $agendamento->id,
            'status' => StatusAgendamento::CONCLUIDO->value
        ]);
    }
}
