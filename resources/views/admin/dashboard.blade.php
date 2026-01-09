@extends('layouts.admin')

@section('content')
@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 8px;">Tableau de bord</h1>
    <p class="text-muted">Aperçu global de l'activité du système.</p>
</div>

<!-- Stats Grid -->
<div class="card-grid">
    <!-- Card 1: Users -->
    <div class="card">
        <div class="card-body">
            <div class="stat-item">
                <div class="stat-icon bg-indigo">
                    <i data-lucide="users"></i>
                </div>
                <div>
                    <div class="stat-label">Total Utilisateurs</div>
                    <div class="stat-value">{{ $stats['totalUsers'] }}</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.users.index') }}" style="color: var(--primary-color);">Voir tout &rarr;</a>
        </div>
    </div>

    <!-- Card 2: Resources -->
    <div class="card">
        <div class="card-body">
            <div class="stat-item">
                <div class="stat-icon bg-emerald">
                    <i data-lucide="box"></i>
                </div>
                <div>
                    <div class="stat-label">Ressources Totales</div>
                    <div class="stat-value">{{ $stats['totalResources'] }}</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.resources.index') }}" style="color: var(--success);">Gérer les ressources &rarr;</a>
        </div>
    </div>

    <!-- Card 3: Active Reservations -->
    <div class="card">
        <div class="card-body">
            <div class="stat-item">
                <div class="stat-icon bg-blue">
                    <i data-lucide="calendar"></i>
                </div>
                <div>
                    <div class="stat-label">Réservations Actives</div>
                    <div class="stat-value">{{ $stats['activeReservations'] }}</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <span class="text-muted">{{ $stats['pendingReservations'] }} en attente</span>
        </div>
    </div>

    <!-- Card 4: Incidents -->
    <div class="card">
        <div class="card-body">
            <div class="stat-item">
                <div class="stat-icon bg-red">
                    <i data-lucide="alert-circle"></i>
                </div>
                <div>
                    <div class="stat-label">Incidents En Cours</div>
                    <div class="stat-value">{{ $stats['pendingIncidents'] }}</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
             <span style="color: var(--danger);">Voir les incidents &rarr;</span>
        </div>
    </div>
    
     <!-- Card 5: Categories -->
    <div class="card">
        <div class="card-body">
            <div class="stat-item">
                <div class="stat-icon bg-purple">
                    <i data-lucide="tags"></i>
                </div>
                <div>
                    <div class="stat-label">Catégories</div>
                    <div class="stat-value">{{ $stats['totalCategories'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex" style="gap: 20px; flex-wrap: wrap;">
    <!-- Notifications -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <div class="table-header">
            <div class="table-title">Notifications Récentes</div>
        </div>
        <div style="padding: 0 20px;">
            @if(auth()->user()->notifications->where('read', false)->count() > 0)
                <ul style="list-style: none; padding: 0;">
                    @foreach(auth()->user()->notifications()->where('read', false)->take(5)->get() as $notif)
                        <li style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; display: flex; gap: 12px;">
                            <div style="color: var(--primary-color);"><i data-lucide="bell" style="width: 16px;"></i></div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem;">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                <div class="text-muted text-sm">{{ $notif->message }}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                    <i data-lucide="bell-off" style="margin-bottom: 8px;"></i>
                    <p>Aucune nouvelle notification.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Role Summary -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <div class="table-header">
             <div class="table-title">Répartition des Utilisateurs</div>
        </div>
        <div style="padding: 20px;">
            <ul style="width: 100%;">
                @foreach($stats['usersByRole'] as $role => $count)
                <li style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e2e8f0;">
                    <div class="flex items-center">
                         <span style="height: 10px; width: 10px; background-color: var(--primary-color); border-radius: 50%; margin-right: 10px;"></span>
                         <span style="font-size: 0.9rem;">{{ $role }}</span>
                    </div>
                    <span class="badge badge-gray">{{ $count }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Account Requests Section -->
<div class="card" style="margin-top: 24px;">
    <div class="table-header">
         <div class="table-title">Demandes de Compte en Attente <span class="badge badge-yellow" style="margin-left: 10px;">{{ $pendingRequests->count() }}</span></div>
    </div>
    <div style="overflow-x: auto;">
        @if($pendingRequests->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle Demandé</th>
                    <th>Justification</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingRequests as $request)
                <tr>
                    <td style="font-weight: 500;">{{ $request->name }}</td>
                    <td class="text-muted">{{ $request->email }}</td>
                     <td>
                         <span class="badge badge-blue">{{ $request->role }}</span>
                     </td>
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $request->justification }}">{{ $request->justification }}</td>
                    <td>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('admin.account-requests.approve', $request->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success" style="padding: 4px 8px; font-size: 12px;">Approuver</button>
                            </form>
                            <form method="POST" action="{{ route('admin.account-requests.reject', $request->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Rejeter</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div style="padding: 30px; text-align: center; color: var(--text-muted);">
                <p>Aucune demande en attente.</p>
            </div>
        @endif
    </div>
</div>
@endsection
@endsection