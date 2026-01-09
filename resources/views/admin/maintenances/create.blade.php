@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.maintenances.index') }}" class="btn" style="background-color: #e2e8f0; color: #475569;">
        <i data-lucide="arrow-left" style="width: 16px; margin-right: 8px;"></i> Retour
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-body">
         <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 20px;">Planifier une Maintenance</h2>

        <form action="{{ route('admin.maintenances.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Ressource concernée</label>
                <select name="resource_id" class="form-control" required>
                    <option value="">-- Sélectionner une ressource --</option>
                    @foreach($resources as $resource)
                        <option value="{{ $resource->id }}">
                            {{ $resource->name }} ({{ $resource->category->name }}) - {{ ucfirst($resource->status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Motif de la maintenance</label>
                <textarea name="reason" class="form-control" rows="3" required placeholder="Ex: Mise à jour système, Remplacement disque dur..."></textarea>
            </div>

            <div class="flex" style="gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Date et Heure de Début</label>
                    <input type="datetime-local" name="start_time" class="form-control" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Date et Heure de Fin (Estimée)</label>
                    <input type="datetime-local" name="end_time" class="form-control">
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Planifier</button>
            </div>
        </form>
    </div>
</div>
@endsection
