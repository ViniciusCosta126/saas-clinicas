@extends('dashboard.layout')

@section('content')
@vite(['resources/js/paciente/index.js'])
    <div class="dashboard-main">
        <x-titulo-dash titulo="Pacientes"
            subtitulo="Aqui você gerencia seus pacientes de forma simples: adicione, edite e exclua quando precisar." />
        <x-card-container>
            <div class="container-btns">
                <div class="page-header-actions">
                    <button class="btn-primary" onclick="openModal('criarNovoPaciente')">
                        <i class="fa-solid fa-plus"></i>
                        <span>Adicionar novo paciente</span>
                    </button>
                    @include('dashboard.pacientes.components.modal-store')
                </div>
            </div>
            @php
                $headers = ['ID', 'Nome', 'Email', 'Aniversario', 'Clinica', 'Ações'];
            @endphp
            <x-smart-table :headers="$headers" id="tabelaPacientes">
                @foreach ($pacientes as $paciente )
                    <tr>
                        <td class="col-id">#{{ $paciente->id }}</td>
                        <td id="nome_paciente{{ $paciente->id }}">{{ $paciente->nome }}</td>
                        <td>
                            <div class="contact-info">
                                <small><i class="fa-regular fa-envelope"></i>{{ $paciente->email }}</small>
                                <small><i class="fa-solid fa-phone"></i> {{ $paciente->telefone }}</small>
                            </div>
                        </td>
                        <td>{{ $paciente->getDataFormatadaAttribute() }}</td>
                        <td>{{ \App\Helpers\ClinicaHelper::getNomeClinica($paciente->clinica_id) }}</td>
                        <td class="text-center">
                            <div class="table-actions">
                                <button onclick="createAgendaento(this)" data-id_paciente="{{ $paciente->id }}" title="Clique aqui para marcar um agendamento" type="button" class="btn-action add">
                                    <i class="fa-regular fa-calendar"></i>
                                </button>
                                <button type="button" class="btn-action edit"                                        
                                    onclick="editPaciente(this)"
                                    data-id="{{ $paciente->id }}"
                                    data-nome="{{ $paciente->nome }}"
                                    data-email="{{ $paciente->email }}"
                                    data-telefone="{{ $paciente->telefone }}"
                                    data-aniversario="{{ optional($paciente->aniversario)->format('Y-m-d') }}"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" onclick="openModal('deletepaciente{{ $paciente->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <x-modal-global id="deletepaciente{{ $paciente->id }}" title="Confirmar Ação">
                                    <p>Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.</p>
                                    <x-slot:footer>
                                        <button class="btn-cancel"
                                            onclick="closeModal('deletepaciente{{ $paciente->id }}')">Cancelar</button>
                                        <form action="{{ route('pacientes.delete', $paciente->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-submit">Confirmar</button>
                                        </form>
                                    </x-slot:footer>
                                </x-modal-global>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-smart-table>
            <div class="pagination-area">
                {{ $pacientes->links('vendor.pagination.saas') }}
            </div>
            @include('dashboard.pacientes.components.modal-edit')
            @include('dashboard.pacientes.components.modal-criar-agendamento')
        </x-card-container>
    </div>
@endsection