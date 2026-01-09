<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KAS') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Custom CSS (No Tailwind) -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <span>KAS</span> ADMIN
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>

            <div class="nav-section">Gestion</div>

            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i data-lucide="users"></i> Utilisateurs
            </a>

            <a href="{{ route('admin.resources.index') }}" class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}">
                <i data-lucide="box"></i> Ressources
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i data-lucide="tag"></i> Catégories
            </a>

            <div class="nav-section">Système</div>

            <a href="{{ route('admin.maintenances.index') }}" class="nav-link {{ request()->routeIs('admin.maintenances.*') ? 'active' : '' }}">
                <i data-lucide="wrench"></i> Maintenance
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">AD</div>
                <div class="user-info">
                    <p style="font-weight: 500; color: white;">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p style="font-size: 12px; color: #94a3b8;">Administrateur</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-left: auto;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Se déconnecter">
                        <i data-lucide="log-out"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <header class="top-header">
            <!-- Mobile Toggle would go here -->
            <h3>Admin Space</h3>
        </header>

        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success">
                    <strong>Succès:</strong> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <strong>Erreur:</strong> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>