@extends('dashboard.layout')

@section('content')
    @vite(['resources/css/dashboard/agendamento/index.scss','resources/js/agendamentos/index.js'])

    <div>
        <x-titulo-dash titulo="Agendamentos"
            subtitulo="Aqui você gerencia seus agendamentos de forma simples: adicione, edite e exclua quando precisar." />
        <x-card-container>
            <div class="container-btns">
                <div class="page-header-actions">
                    <button onclick="openModal('modalCriarAgendamento')" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Novo Agendamento
                    </button>
                    @include('dashboard.agendamentos.components.modal-store',['pacientes'=>$pacientes])
                    <div class="date-picker-wrapper">
                        <i class="fa-solid fa-calendar-day"></i>
                        <input type="date" id="data_agenda" value="{{ $dataSelecionada }}" class="input-date-clean"
                            onchange="window.location.href='?data='+this.value">
                    </div>
                </div>
            </div>
            <div class="agenda-body">
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
                                        <button class="btn-action edit" title="Editar"><i class="fa-solid fa-pen"></i></button>
                                        <button class="btn-action add" title="Confirmar Presença"><i
                                                class="fa-solid fa-check"></i></button>
                                        <button class="btn-action delete" title="Cancelar"><i
                                                class="fa-solid fa-xmark"></i></button>
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
                                    <div class="empty-slot"
                                        onclick="prepararAgendamento('{{ $hora }}','{{ $dataSelecionada }}')">
                                        <i class="fa-solid fa-plus-circle"></i>
                                        <span>Disponível para agendamento</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card-container>


    </div>
@endsection