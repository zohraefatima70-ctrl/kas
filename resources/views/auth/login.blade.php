@extends('layouts/auth')

@section('content')
<h2>Connexion</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
<p>Nouveau ? <a href="{{ route('register') }}">Créer un compte</a></p>
@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
    </div>
@endif
@endsection