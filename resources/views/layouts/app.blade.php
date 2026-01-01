<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DC Resa | Gestion des Ressources Data Center</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles') 
</head>
<body>
    
    <header class="main-header">
        <div class="logo">DC Resa</div>
        
        @auth
            @include('layouts.navigation') 
        @else
            <nav>
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('register') }}">Inscription</a>
            </nav>
        @endauth
    </header>

    <main class="main-content">
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif
        
        @yield('content')
    </main>
    
    <footer class="main-footer">
        <p>&copy; {{ date('Y') }} Data Center Resource Booking. Tous droits réservés.</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>