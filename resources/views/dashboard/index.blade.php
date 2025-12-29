@extends('dashboard.layout')

@section('content')
    @include('dashboard.partials.kpis')

    <div class="dashboard-grid">
        @include('dashboard.partials.agenda-preview')
        @include('dashboard.partials.activities')
    </div>
@endsection
