@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 8px;">Gestion des Ressources</h1>
        <p class="text-muted">Liste complète des ressources du Data Center.</p>
    </div>
    <a href="{{ route('admin.resources.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="margin-right: 8px; width: 16px;"></i> Nouvelle Ressource
    </a>
</div>

<div class="card">
    <div class="table-header">
        <div class="table-title">Liste des Ressources</div>
        <div style="font-size: 0.875rem; color: #64748b;">
            Total: {{ $resources->count() }}
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Statut</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Specs (CPU/RAM/Sto/OS)</th>
                    <th>Localisation</th>
                    <th>Manager</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                <tr>
                    <td>
                        @if($resource->status == 'active')
                            <span class="badge badge-green">Actif</span>
                        @elseif($resource->status == 'maintenance')
                            <span class="badge badge-yellow">Maintenance</span>
                        @else
                            <span class="badge badge-red">Hors service</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $resource->name }}</div>
                        <div style="font-size: 12px; color: #94a3b8;">ID: {{ $resource->id }}</div>
                    </td>
                    <td>{{ $resource->category->name ?? 'N/A' }}</td>
                    <td>
                        <div style="font-size: 12px;">
                            <span title="CPU"><i data-lucide="cpu" style="width: 12px; display:inline;"></i> {{ $resource->cpu_cores }} Cores</span> | 
                            <span title="RAM"><i data-lucide="memory-stick" style="width: 12px; display:inline;"></i> {{ $resource->ram_gb }} GB</span>
                        </div>
                        <div style="font-size: 12px; color: #64748b;">
                            {{ $resource->storage_tb }} TB - {{ $resource->os_name }}
                        </div>
                    </td>
                    <td>{{ $resource->location }}</td>
                    <td>
                        @if($resource->manager)
                            <div style="display: flex; align-items: center;">
                                <div style="width: 20px; height: 20px; background-color: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; margin-right: 6px;">
                                    {{ substr($resource->manager->name, 0, 1) }}
                                </div>
                                <span style="font-size: 13px;">{{ $resource->manager->name }}</span>
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                         <a href="{{ route('admin.resources.edit', $resource->id) }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Modifier</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                        <i data-lucide="box" style="margin-bottom: 8px; width: 24px; height: 24px;"></i>
                        <p>Aucune ressource trouvée.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
