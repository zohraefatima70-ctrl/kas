<!DOCTYPE html>
<html>
<head>
    <title>Responsable - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<nav>
    <a href="{{ route('manager.dashboard') }}">Dashboard</a>
    <a href="{{ route('manager.reservations.index') }}">Réservations supervisées</a>
    <a href="{{ route('manager.incidents.index') }}">Incidents</a>
    <form method="POST" action="{{ route('logout') }}">@csrf<button>Déconnexion</button></form>
</nav>
<main>
    @yield('content')
</main>
</body>
</html>