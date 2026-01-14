@extends('dashboard.layout')

@section('content')
@vite(['resources/js/profissionais/index.js'])
    <div class="dashboard-main">
        <x-titulo-dash titulo="Profissionais"
            subtitulo="Aqui você gerencia seus profissionais de forma simples: adicione, edite e exclua quando precisar." />
        <x-card-container>
            <div class="container-btns">
                <div class="page-header-actions">
                    <button class="btn-primary" onclick="openModal('criarNovoProfissional')">
                        <i class="fa-solid fa-plus"></i>
                        <span>Adicionar novo profissional</span>
                    </button>
                </div>
                @include('dashboard.profissionais.components.modal-store',[$usuarios])
            </div>
            @php
                $headers = ['ID', 'Nome', 'Email', 'Especialidade', 'Preço Sessão', 'Ações'];
            @endphp
            <x-smart-table :headers="$headers" id="tabelaUsuarios">
                @foreach($profissionais as $profissional)
                    <tr>
                        <td class="col-id">#{{ $profissional->id }}</td>
                        <td>{{ $profissional->nome }}</td>
                        <td>
                            <div class="contact-info">
                                <small><i class="fa-regular fa-envelope"></i> {{ $profissional->email }}</small>
                            </div>
                        </td>
                        <td>
                            {{ $profissional->especialidade }}
                        </td>
                        <td>{{ $profissional->preco_sessao }}</td>
                        <td class="text-center">
                            <div class="table-actions">
                                <button type="button" class="btn-action edit"                                        
                                        onclick="editUser(this)"
                                        data-id="{{ $profissional->id }}"
                                        data-preco_sessao="{{  number_format($profissional->preco_sessao, 2, '.', '') }}"
                                        data-especialidade="{{ $profissional->especialidade }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" onclick="openModal('deleteProfissional{{ $profissional->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <x-modal-global id="deleteProfissional{{ $profissional->id }}" title="Confirmar Ação">
                                    <p>Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.</p>
                                    <x-slot:footer>
                                        <button class="btn-cancel"
                                            onclick="closeModal('deleteProfissional{{ $profissional->id }}')">Cancelar</button>
                                        <form action="{{ route('profissionais.delete', $profissional->id) }}" method="POST">
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
            @include('dashboard.profissionais.components.modal-edit')
            <div class="pagination-area">
                {{ $profissionais->links('vendor.pagination.saas') }}
            </div>
        </x-card-container>
    </div>
@endsection