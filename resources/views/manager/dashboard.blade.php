@extends('layouts.manager')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tableau de Bord Supervision</h1>
        <p class="page-subtitle">Gérez les demandes de réservation et supervisez vos ressources affectées.</p>
    </div>
</div>

<div class="grid-3" style="margin-bottom: 32px;">
    <!-- Stat Cards -->
    <div class="card" style="display: flex; align-items: center; padding: 24px;">
        <div style="background-color: #f5f3ff; width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); margin-right: 20px;">
            <i data-lucide="inbox" style="width: 28px; height: 28px;"></i>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; line-height: 1;">{{ $pendingRequests->count() }}</div>
            <div style="color: var(--text-muted);">Demandes en attente</div>
        </div>
    </div>
    
    <div class="card" style="display: flex; align-items: center; padding: 24px;">
        <div style="background-color: #ecfdf5; width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #059669; margin-right: 20px;">
            <i data-lucide="check-circle" style="width: 28px; height: 28px;"></i>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; line-height: 1;">{{ $activeReservationsCount }}</div>
            <div style="color: var(--text-muted);">Réservations Active</div>
        </div>
    </div>

    <div class="card" style="display: flex; align-items: center; padding: 24px;">
        <div style="background-color: #eff6ff; width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2563eb; margin-right: 20px;">
            <i data-lucide="server" style="width: 28px; height: 28px;"></i>
        </div>
        <div>
            <div style="font-size: 2rem; font-weight: 700; line-height: 1;">{{ $myResourcesCount }}</div>
            <div style="color: var(--text-muted);">Ressources supervisées</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Demandes en Attente d'Approbation
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Ressource</th>
                    <th>Période Demandée</th>
                    <th>Motif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRequests as $request)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $request->user->name }}</div>
                        <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $request->user->email }}</div>
                    </td>
                    <td>
                        <div>{{ $request->resource->name }}</div>
                    </td>
                    <td>
                        <div style="font-size: 0.9rem;">
                            <span style="color: var(--text-muted);">Du:</span> {{ \Carbon\Carbon::parse($request->start_time)->format('d/m/Y H:i') }}
                        </div>
                        <div style="font-size: 0.9rem;">
                            <span style="color: var(--text-muted);">Au:</span> {{ \Carbon\Carbon::parse($request->end_time)->format('d/m/Y H:i') }}
                        </div>
                    </td>
                    <td>
                         <span style="color: var(--text-muted); font-size: 0.9rem;">
                            {{ $request->reason ?? 'Aucun motif' }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('manager.reservations.approve', $request->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" style="padding: 6px 12px; font-size: 0.85rem;">Approuver</button>
                            </form>
                            <form action="{{ route('manager.reservations.reject', $request->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85rem;">Refuser</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i data-lucide="check-check" style="margin-bottom: 8px; width: 32px; height: 32px; color: #cbd5e1;"></i>
                        <p>Aucune demande en attente. Tout est à jour !</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection