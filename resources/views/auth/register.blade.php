@extends('layouts/auth')

@section('content')
<h2>Créer un compte</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="name" placeholder="Nom complet" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
    <button type="submit">S'inscrire</button>
</form>
<p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
@endsection