@extends('dashboard.layout')

@section('content')
    @include('dashboard.partials.kpis', ["profissionais" => $profissionais, "pacientes" => $pacientes, 'agendamentos' => $agendamentos])

    <div class="dashboard-grid">
        @include('dashboard.partials.agenda-preview')
    </div>
@endsection