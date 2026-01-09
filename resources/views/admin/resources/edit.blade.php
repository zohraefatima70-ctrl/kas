@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.resources.index') }}" class="btn" style="background-color: #e2e8f0; color: #475569;">
        <i data-lucide="arrow-left" style="width: 16px; margin-right: 8px;"></i> Retour
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 20px;">Modifier la Ressource: {{ $resource->name }}</h2>

        <form action="{{ route('admin.resources.update', $resource->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Informations Générales -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">Informations Générales</h3>
                
                <div class="form-group">
                    <label class="form-label">Nom de la ressource</label>
                    <input type="text" name="name" class="form-control" value="{{ $resource->name }}" required>
                </div>

                <div class="flex" style="gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Catégorie</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $resource->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ $resource->status == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="hors_service" {{ $resource->status == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $resource->description }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Localisation Physique</label>
                    <input type="text" name="location" class="form-control" value="{{ $resource->location }}">
                </div>
            </div>

            <!-- Spécifications Techniques -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">Spécifications Techniques</h3>
                
                <div class="flex" style="gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">CPU (Cores)</label>
                        <input type="number" name="cpu_cores" class="form-control" min="1" value="{{ $resource->cpu_cores }}">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">RAM (GB)</label>
                        <input type="number" name="ram_gb" class="form-control" min="1" value="{{ $resource->ram_gb }}">
                    </div>
                </div>

                <div class="flex" style="gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Stockage (TB)</label>
                        <input type="number" name="storage_tb" class="form-control" step="0.1" min="0" value="{{ $resource->storage_tb }}">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Système d'exploitation</label>
                        <input type="text" name="os_name" class="form-control" value="{{ $resource->os_name }}">
                    </div>
                </div>
            </div>

            <!-- Management -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">Gestion</h3>
                
                <div class="form-group">
                    <label class="form-label">Responsable Technique</label>
                    <select name="manager_id" class="form-control">
                        <option value="">-- Sélectionner un responsable --</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ $resource->manager_id == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
