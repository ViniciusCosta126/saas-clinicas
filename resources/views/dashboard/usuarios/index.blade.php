@extends('dashboard.layout')

@section('content')
    @vite(['resources/css/dashboard/usuarios/formulario-criacao.scss','resources/js/usuarios/editForm.js'])
    <div class="dashboard-main">
        <x-titulo-dash titulo="Todos os usuários" subtitulo="Gerencie seus usuários aqui" />
        <x-card-container>
            <div class="container-btns">
                <div class="page-header-actions">
                    <button class="btn-primary" onclick="openModal('criarNovoUsuario')">
                        <i class="fa-solid fa-plus"></i>
                        <span>Adicionar novo usuário</span>
                    </button>
                </div>
                @include('dashboard.usuarios.components.modal-store')
            </div>
            @php
                $headers = ['ID', 'Nome', 'CPF', 'Contato', 'Função', 'Criado em', 'Ações'];
            @endphp
            <x-smart-table :headers="$headers" id="tabelaUsuarios">
                @foreach($usuarios as $usuario)
                    <tr>
                        <td class="col-id">#{{ $usuario->id }}</td>
                        <td>
                            <div class="user-cell">
                                <img src="{{ $usuario->profile_photo }}" class="mini-avatar">
                                <span>{{ $usuario->name }}</span>
                            </div>
                        </td>
                        <td>{{ $usuario->cpf }}</td>
                        <td>
                            <div class="contact-info">
                                <small><i class="fa-regular fa-envelope"></i> {{ $usuario->email }}</small>
                                @if ($usuario->telefone)
                                    <small><i class="fa-solid fa-phone"></i> {{ $usuario->telefone }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge-table badge-table-{{ $usuario->role }}">
                                {{ ucfirst($usuario->role) }}
                            </span>
                        </td>
                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="table-actions">
                                <button type="button" 
                                        class="btn-action edit" 
                                        onclick="editUser(this)"
                                        data-id="{{ $usuario->id }}"
                                        data-telefone="{{ $usuario->telefone }}"
                                        data-cpf="{{ $usuario->cpf }}"
                                        data-nome="{{ $usuario->name }}"
                                        data-email="{{ $usuario->email }}"
                                        data-role="{{ $usuario->role }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" onclick="openModal('deleteUser{{ $usuario->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <x-modal-global id="deleteUser{{ $usuario->id }}" title="Confirmar Ação">
                                    <p>Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.</p>
                                    <x-slot:footer>
                                        <button class="btn-cancel"
                                            onclick="closeModal('deleteUser{{ $usuario->id }}')">Cancelar</button>
                                        <form action="{{ route('usuarios.delete', $usuario->id) }}" method="POST">
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
                {{ $usuarios->links('vendor.pagination.saas') }}
            </div>
            @include('dashboard.usuarios.components.modal-edit')
        </x-card-container>
    </div>
@endsection