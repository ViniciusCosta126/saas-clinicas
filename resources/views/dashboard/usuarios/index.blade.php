@extends('dashboard.layout')

@section('content')
    <div class="dashboard-main">
        <x-titulo-dash titulo="Todos os usuarios" subtitulo="Utilize esta tela para gerenciar todos os seus usuarios" />
        <x-card-container>
            <table>
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Nome</td>
                        <td>Cpf</td>
                        <td>Email</td>
                        <td>Telefone</td>
                        <td>Função</td>
                        <td>Data de criação</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- <button onclick="openModal('modalExemplo')" class="btn-primary">
                Abrir Modal
            </button>

            <x-modal-global id="modalExemplo" title="Confirmar Ação">
                <p>Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.</p>

                <x-slot:footer>
                    <button class="btn-cancel" onclick="closeModal('modalExemplo')">Cancelar</button>
                    <button class="btn-submit">Confirmar</button>
                </x-slot:footer>
            </x-modal-global> -->
        </x-card-container>
    </div>
@endsection