@extends('dashboard.layout')

@section('content')
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
                        <td>{{ $paciente->nome }}</td>
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
                                <button type="button" class="btn-action edit"                                        
                                        onclick="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" onclick="">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-smart-table>
            <div class="pagination-area">
                {{ $pacientes->links('vendor.pagination.saas') }}
            </div>
        </x-card-container>
    </div>
@endsection