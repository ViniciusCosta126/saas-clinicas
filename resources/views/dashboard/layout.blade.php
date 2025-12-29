<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Painel da Clínica</title>
    @vite(['resources/css/app.scss','resources/css/dashboard/dashboard.scss', 'resources/js/dashboard.js'])
</head>
<body class="dashboard">
    @include('dashboard.partials.sidebar')
    <div class="dashboard-content">
        @include('dashboard.partials.topbar')
        <main class="dashboard-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
