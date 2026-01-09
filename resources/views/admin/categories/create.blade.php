@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.categories.index') }}" class="btn" style="background-color: #e2e8f0; color: #475569;">
        <i data-lucide="arrow-left" style="width: 16px; margin-right: 8px;"></i> Retour
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-body">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 20px;">Nouvelle Catégorie</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Nom de la catégorie</label>
                <input type="text" name="name" class="form-control" required placeholder="Ex: Serveurs Physiques">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description de cette catégorie de ressources..."></textarea>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Créer la catégorie</button>
            </div>
        </form>
    </div>
</div>
@endsection
