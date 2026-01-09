@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 8px;">Gestion des Maintenances</h1>
        <p class="text-muted">Planifiez et suivez les maintenances des ressources.</p>
    </div>
    <a href="{{ route('admin.maintenances.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="margin-right: 8px; width: 16px;"></i> Planifier une Maintenance
    </a>
</div>

<div class="card">
    <div class="table-header">
         <div class="table-title">Liste des Maintenances</div>
    </div>
    
    <div style="overflow-x: auto;">
         <table>
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Motif</th>
                    <th>Date de début</th>
                    <th>Date de fin (est.)</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $maintenance)
                <tr>
                    <td>
                        <div style="font-weight: 500;">
                            {{ $maintenance->resource->name }}
                        </div>
                         <div style="font-size: 12px; color: #94a3b8;">{{ $maintenance->resource->category->name ?? 'N/A' }}</div>
                    </td>
                    <td>{{ $maintenance->reason }}</td>
                    <td>
                        <div>
                             <i data-lucide="calendar" style="width: 12px; display:inline;"></i>
                             {{ \Carbon\Carbon::parse($maintenance->start_time)->format('d/m/Y H:i') }}
                        </div>
                    </td>
                    <td>
                        @if($maintenance->end_time)
                            <div>
                                <i data-lucide="calendar-check" style="width: 12px; display:inline;"></i>
                                {{ \Carbon\Carbon::parse($maintenance->end_time)->format('d/m/Y H:i') }}
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                         @if($maintenance->status == 'scheduled')
                            <span class="badge badge-yellow">Planifiée</span>
                        @elseif($maintenance->status == 'in_progress')
                             <span class="badge badge-blue">En cours</span>
                        @elseif($maintenance->status == 'completed')
                             <span class="badge badge-green">Terminée</span>
                        @else
                             <span class="badge badge-red">Annulée</span>
                        @endif
                    </td>
                    <td>
                        <!-- Actions Futures (Modifier, Annuler, Terminer) -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                        <p>Aucune maintenance planifiée.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">
    {{ $maintenances->links() }}
</div>
@endsection
