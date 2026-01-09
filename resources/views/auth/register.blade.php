@extends('layouts/auth')

@section('content')
<h2>Créer un compte</h2>

{{-- Affichage des erreurs --}}
@if ($errors->any())
    <div style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Message de succès --}}
@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <input type="text" name="name" placeholder="Nom complet" value="{{ old('name') }}" required>

    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>

    <select name="role" required>
        <option value="">-- Choisir un rôle --</option>
        <option value="student">Étudiant</option>
        <option value="teacher">Enseignant</option>
    </select>

    <textarea name="justification" placeholder="Pourquoi souhaitez-vous créer un compte ?" required>
        {{ old('justification') }}
    </textarea>

    <button type="submit">Envoyer la demande</button>
</form>

<p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
@endsection
