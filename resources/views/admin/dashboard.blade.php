@extends('layouts/admin')

@section('content')
<h1>Bonjour Admin {{ auth()->user()->name }}</h1>

<div class="notifications">
    <h3>Notifications importantes</h3>
    <ul>
        @foreach(auth()->user()->notifications()->where('read', false)->get() as $notif)
            <li>{{ $notif->message }} <small>{{ $notif->created_at->diffForHumans() }}</small></li>
        @endforeach
        @if(auth()->user()->notifications()->where('read', false)->count() == 0)
            <li>Aucune nouvelle notification.</li>
        @endif
    </ul>
</div>

<h2>Résumé global</h2>
<div class="stats">
    <div class="stat-card">
        <h3>{{ $users->count() }}</h3>
        <p>Utilisateurs</p>
    </div>
    <div class="stat-card">
        <h3>{{ $resources->count() }}</h3>
        <p>Ressources</p>
    </div>
    <div class="stat-card">
        <h3>{{ $incidents->count() }}</h3>
        <p>Incidents</p>
    </div>
</div>
@endsection