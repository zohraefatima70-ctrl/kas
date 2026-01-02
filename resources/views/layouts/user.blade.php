<!DOCTYPE html>
<html>
<head>
    <title>Utilisateur - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<nav>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
    <a href="{{ route('user.reservations.index') }}">Réservations</a>
    <a href="{{ route('user.incidents.index') }}">Incidents</a>
    <form method="POST" action="{{ route('logout') }}">@csrf<button>Déconnexion</button></form>
</nav>
<main>
    @yield('content')
</main>
</body>
</html>