<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Painel da Clínica</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/dashboard/dashboard.scss', 'resources/js/dashboard.js'])
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