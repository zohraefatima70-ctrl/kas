@extends('layouts/user')

@section('content')
<h1>Bienvenue {{ auth()->user()->name }}</h1>

<div class="notifications">
    <h3>Notifications</h3>
    <ul>
        @foreach(auth()->user()->notifications()->where('read', false)->get() as $notif)
            <li>{{ $notif->message }} <small>{{ $notif->created_at->diffForHumans() }}</small></li>
        @endforeach
        @if(auth()->user()->notifications()->where('read', false)->count() == 0)
            <li>Aucune nouvelle notification.</li>
        @endif
    </ul>
</div>

<h2>Réservations</h2>
<table>
<tr>
    <th>Ressource</th>
    <th>Début</th>
    <th>Fin</th>
    <th>Status</th>
</tr>
@foreach($reservations as $res)
<tr class="status-{{ strtolower($res->status) }}">
    <td>{{ $res->resource->name }}</td>
    <td>{{ $res->start_date }}</td>
    <td>{{ $res->end_date }}</td>
    <td>{{ $res->status }}</td>
</tr>
@endforeach
</table>

<div class="stats">
    <div class="stat-card">
        <h3>{{ $reservations->count() }}</h3>
        <p>Total réservations</p>
    </div>
    <div class="stat-card">
        <h3>{{ $reservations->where('status','active')->count() }}</h3>
        <p>Réservations actives</p>
    </div>
    <div class="stat-card">
        <h3>{{ $incidents->count() }}</h3>
        <p>Incidents signalés</p>
    </div>
</div>
@endsection