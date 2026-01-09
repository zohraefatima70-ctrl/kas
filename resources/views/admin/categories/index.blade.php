@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 8px;">Gestion des Catégories</h1>
        <p class="text-muted">Gérez les types de ressources disponibles.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="margin-right: 8px; width: 16px;"></i> Nouvelle Catégorie
    </a>
</div>

<div class="card">
    <div class="table-header">
         <div class="table-title">Liste des Catégories</div>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Nombre de Ressources</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td style="font-weight: 500;">
                        <div class="flex items-center">
                            <span style="width: 8px; height: 8px; background-color: var(--primary-color); border-radius: 50%; margin-right: 8px;"></span>
                            {{ $category->name }}
                        </div>
                    </td>
                    <td class="text-muted">{{ Str::limit($category->description, 50) }}</td>
                    <td>
                        <span class="badge badge-gray">{{ $category->resources_count }} ressource(s)</span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 8px;">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Modifier</a>
                            
                            @if($category->resources_count == 0)
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Supprimer</button>
                            </form>
                            @else
                                <span class="badge badge-yellow" title="Impossible de supprimer une catégorie utilisée">Utilisée</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">
                        <p>Aucune catégorie trouvée.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection
