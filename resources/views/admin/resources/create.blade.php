@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.resources.index') }}" class="btn" style="background-color: #e2e8f0; color: #475569;">
        <i data-lucide="arrow-left" style="width: 16px; margin-right: 8px;"></i> Retour
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 20px;">Nouvelle Ressource</h2>

        <form action="{{ route('admin.resources.store') }}" method="POST">
            @csrf

            <!-- Informations Générales -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">Informations Générales</h3>
                
                <div class="form-group">
                    <label class="form-label">Nom de la ressource</label>
                    <input type="text" name="name" class="form-control" required placeholder="Ex: Serveur Alpha-01">
                </div>

                <div class="flex" style="gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Catégorie</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Statut Initial</label>
                        <select name="status" class="form-control" required>
                            <option value="active">Actif</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="hors_service">Hors Service</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Description détaillée..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Localisation Physique</label>
                    <input type="text" name="location" class="form-control" placeholder="Ex: Salle B, Baie 4, U-12">
                </div>
            </div>

            <!-- Spécifications Techniques -->
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">Spécifications Techniques</h3>
                
                <div class="flex" style="gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">CPU (Cores)</label>
                        <input type="number" name="cpu_cores" class="form-control" min="1" placeholder="Ex: 16">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">RAM (GB)</label>
                        <input type="number" name="ram_gb" class="form-control" min="1" placeholder="Ex: 64">
                    </div>
                </div>

                <div class="flex" style="gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Stockage (TB)</label>
                        <input type="number" name="storage_tb" class="form-control" step="0.1" min="0" placeholder="Ex: 2.5">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Système d'exploitation</label>
                        <input type="text" name="os_name" class="form-control" placeholder="Ex: Ubuntu 22.04 LTS">
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
                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Créer la ressource</button>
            </div>
        </form>
    </div>
</div>
@endsection
