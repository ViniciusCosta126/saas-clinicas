@extends('dashboard.layout')

@section('content')
@vite(['resources/css/dashboard/clinica/index.scss'])
<div class="dashboard-main">
    <div class="page-header">
        <div class="header-info">
            <h1>Dados da Clínica</h1>
            <p>Informações de registro e contato da unidade.</p>
        </div>
    </div>

    <div class="clinic-display-grid">
        <div class="info-card">
            <div class="info-card-header">
                <div class="icon-box">
                    <i class="fa-solid fa-hospital"></i>
                </div>
                <div>
                    <h3>{{ $clinica->nome_clinica }}</h3>
                    <span>ID do Registro: #{{ str_pad($clinica->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            <div class="info-card-body">
                <div class="info-item">
                    <label>Responsável Técnico</label>
                    <p>{{ $clinica->nome_responsavel }}</p>
                </div>

                <div class="info-item">
                    <label>E-mail de Contato</label>
                    <p><i class="fa-regular fa-envelope"></i> {{ $clinica->email }}</p>
                </div>

                <div class="info-item">
                    <label>Telefone / WhatsApp</label>
                    <p><i class="fa-solid fa-phone"></i> {{ $clinica->telefone }}</p>
                </div>
            </div>
        </div>

        <div class="info-card status-card">
            <div class="status-badge active">
                <i class="fa-solid fa-circle-check"></i> Unidade Ativa
            </div>
            <p class="since-text">Cliente desde {{ $clinica->created_at->format('d/m/Y') }}</p>
            <!-- <hr> -->
            <!-- <div class="support-info">
                <p>Precisa alterar algum dado? Entre em contato com o suporte do sistema.</p>
                <a href="#" class="btn-support">Falar com Suporte</a>
            </div> -->
        </div>
    </div>
</div>
@endsection