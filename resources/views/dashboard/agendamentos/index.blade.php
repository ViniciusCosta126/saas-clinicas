@extends('dashboard.layout')

@section('content')
    @vite(['resources/css/dashboard/agendamento/index.scss', 'resources/js/agendamentos/index.js'])

    <div>
        <x-titulo-dash titulo="Agendamentos"
            subtitulo="Aqui você gerencia seus agendamentos de forma simples: adicione, edite e exclua quando precisar." />
        <x-card-container>
            <div class="container-btns">
                <div class="page-header-actions">
                    <button onclick="openModal('modalCriarAgendamento')" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Novo Agendamento
                    </button>
                    @include('dashboard.agendamentos.components.modal-store', ['pacientes' => $pacientes])
                    <div class="date-picker-wrapper">
                        <i class="fa-solid fa-calendar-day"></i>
                        <input type="date" id="data_agenda" value="{{ $dataSelecionada }}" class="input-date-clean"
                            onchange="window.location.href='?data='+this.value">
                    </div>
                    <div class="view-switcher">
                        <a href="?view=diario&data={{ $dataSelecionada }}" class="btn-view {{ $view == 'diario' ? 'active' : '' }}">Dia</a>
                        <a href="?view=semanal&data={{ $dataSelecionada }}" class="btn-view {{ $view == 'semanal' ? 'active' : '' }}">Semana</a>
                    </div>
                </div>
            </div>
            <div class="agenda-body">
                @if($view == 'diario')
                    @foreach($horarios as $hora)
                        <div class="agenda-row">
                            <div class="time-marker">
                                <span>{{ $hora }}</span>
                            </div>

                            <div class="appointment-slot">
                                @php $item = $agendamentos->firstWhere('horario_inicio', $hora); @endphp

                                @if($item)
                                    <div class="appointment-card status-{{ $item->status }}">
                                        <div class="patient-avatar">
                                            {{ substr($item->paciente->nome, 0, 1) }}
                                        </div>
                                        <div class="patient-details">
                                            <strong>{{ $item->paciente->nome }}</strong>
                                            <span><i class="fa-regular fa-clock"></i> {{ $hora }} -
                                                {{ \Carbon\Carbon::parse($item->horario_fim)->format('H:i') }}</span>
                                        </div>
                                        <div class="table-actions">
                                            @if($item->status != "nao_compareceu" && $item->status != 'concluído')
                                                <button data-id="{{ $item->id }}" onclick="concluirAgendamento(this)"
                                                    class="btn-action done" title="Finalizar Atendimento">
                                                    <i class="fa-solid fa-file-circle-check"></i>
                                                </button>

                                                <button data-id="{{ $item->id }}" onclick="confirmarPresenca(this)" class="btn-action add"
                                                    title="Confirmar presença do paciente">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>

                                                <button data-id="{{ $item->id }}" onclick="cancelaAgendamento(this)"
                                                    class="btn-action delete" title="Cancelar"><i class="fa-solid fa-xmark"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $timezone = config('app.timezone');
                                        $agora = now($timezone);

                                        $dataSlot = \Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i',
                                            $dataSelecionada . ' ' . $hora,
                                            $timezone
                                        );

                                        $dataSelecionadaCarbon = \Carbon\Carbon::parse($dataSelecionada, $timezone);

                                        $slotBloqueado =
                                            $dataSelecionadaCarbon->isBefore(today($timezone))
                                            || (
                                                $dataSelecionadaCarbon->isToday()
                                                && $dataSlot->lessThanOrEqualTo($agora)
                                            );
                                    @endphp
                                    @if($slotBloqueado)
                                        <div class="empty-slot disabled">
                                            <i class="fa-solid fa-ban"></i>
                                            <span>Horário encerrado</span>
                                        </div>
                                    @else
                                        <div class="empty-slot" onclick="prepararAgendamento('{{ $hora }}','{{ $dataSelecionada }}')">
                                            <i class="fa-solid fa-plus-circle"></i>
                                            <span>Disponível para agendamento</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @elseif($view == 'semanal')
                        <div class="semana-grid">
                            <div class="time-col">
                                @foreach($horarios as $hora)
                                    <span>{{ $hora }}</span>
                                @endforeach
                            </div>
                            @php
                                $inicioSemana = \Carbon\Carbon::parse($dataSelecionada)->startOfWeek();
                                $hoje = today(config('app.timezone'))->format('Y-m-d');
                            @endphp

                            @for($i = 0; $i < 7; $i++)
                                @php $diaAtual = $inicioSemana->copy()->addDays($i); @endphp
                                
                                <div class="dia-coluna">
                                    <div class="col-header {{ $diaAtual->format('Y-m-d') == $hoje ? 'hoje' : '' }}">
                                        <span class="dia-nome">{{ ucfirst($diaAtual->locale('pt_BR')->translatedFormat('l')) }}</span>
                                        <span class="dia-data">{{ $diaAtual->format('d/m/y') }}</span>
                                    </div>

                                    @foreach($horarios as $hora)
                                        @php 
                                            $item = $agendamentos->first(function($agend) use ($diaAtual, $hora) {
                                                return \Carbon\Carbon::parse($agend->data)->isSameDay($diaAtual) 
                                                    && $agend->horario_inicio == $hora;
                                            });
                                            $dataSlot = \Carbon\Carbon::parse($diaAtual->format('Y-m-d') . ' ' . $hora);
                                            $isPassado = $dataSlot->isPast();
                                        @endphp

                                        @if($item)
                                            <div class="slot-semanal ocupado status-{{ $item->status }}" title="{{ $item->paciente->nome }}">
                                                <strong>{{$item->paciente->nome}}</strong>
                                                <span>{{ $hora }}</span>
                                                <div class="slot-actions">
                                                    @if($item->status != "nao_compareceu" && $item->status != 'concluído')
                                                        <button onclick="concluirAgendamento(this)" data-id="{{ $item->id }}" class="action-mini done" title="Finalizar">
                                                            <i class="fa-solid fa-file-circle-check"></i>
                                                        </button>
                                                        <button onclick="confirmarPresenca(this)" data-id="{{ $item->id }}" class="action-mini add" title="Confirmar">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                        <button onclick="cancelaAgendamento(this)" data-id="{{ $item->id }}" class="action-mini delete" title="Cancelar">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($isPassado)
                                            <div class="slot-semanal bloqueado">
                                                <i class="fa-solid fa-ban"></i>
                                            </div>
                                        @else
                                            <div class="slot-semanal disponivel" onclick="prepararAgendamento('{{ $hora }}','{{ $diaAtual->format('Y-m-d') }}')">
                                                <i class="fa-solid fa-plus" style="opacity: 0.3"></i>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                @elseif($view == 'mensal')
                    {{-- Aqui você pode integrar uma biblioteca como FullCalendar.js ou criar uma grade 7x5 --}}
                    <p>Visão mensal (Grade de calendário)</p>
                @endif
            </div>
        </x-card-container>
        @include('dashboard.agendamentos.components.modal-confirma-cancelamento')
        @include('dashboard.agendamentos.components.modal-confirmar-presenca')
        @include('dashboard.agendamentos.components.modal-confirma-comparecimento')
    </div>
@endsection