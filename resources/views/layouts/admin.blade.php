<!DOCTYPE html>
<html>
<head>
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<nav>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.users.index') }}">Utilisateurs</a>
    <a href="{{ route('admin.resources.index') }}">Ressources</a>
    <a href="{{ route('admin.categories.index') }}">Catégories</a>
    <a href="{{ route('admin.maintenances.index') }}">Maintenance</a>
    <form method="POST" action="{{ route('logout') }}">@csrf<button>Déconnexion</button></form>
</nav>
<main>
    @yield('content')
</main>
</body>
</html>