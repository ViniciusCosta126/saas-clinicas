@extends('dashboard.layout')

@section('content')
    <div class="dashboard-main">
        <x-titulo-dash titulo="Profissionais"
            subtitulo="Aqui você gerencia seus profissionais de forma simples: adicione, edite e exclua quando precisar." />
        <x-card-container>
            @php
                $headers = ['ID', 'Nome', 'Email', 'Especialidade', 'Preço Sessão', 'Ações'];
            @endphp
            <x-smart-table :headers="$headers" id="tabelaUsuarios">
                @foreach($profissionais as $profissional)
                    <tr>
                        <td class="col-id">#{{ $profissional->id }}</td>
                        <td>

                        </td>
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
                                <button type="button" class="btn-action edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-smart-table>

            <div class="pagination-area">
                {{ $profissionais->links('vendor.pagination.saas') }}
            </div>
        </x-card-container>
    </div>
@endsection