@extends('layouts/manager')

@section('content')
<h1>Bonjour {{ auth()->user()->name }} (Responsable)</h1>

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

<h2>Réservations supervisées</h2>
<table>
<tr>
    <th>Utilisateur</th>
    <th>Ressource</th>
    <th>Début</th>
    <th>Fin</th>
    <th>Status</th>
    <th>Action</th>
</tr>
@foreach($reservations as $res)
<tr class="status-{{ strtolower($res->status) }}">
    <td>{{ $res->user->name }}</td>
    <td>{{ $res->resource->name }}</td>
    <td>{{ $res->start_date }}</td>
    <td>{{ $res->end_date }}</td>
    <td>{{ $res->status }}</td>
    <td>
        @if($res->status == 'pending')
        <form method="POST" action="{{ route('manager.reservations.approve', $res->id) }}" style="display:inline;">
            @csrf
            <button class="approve">Approuver</button>
        </form>
        <form method="POST" action="{{ route('manager.reservations.reject', $res->id) }}" style="display:inline;">
            @csrf
            <button class="reject">Refuser</button>
        </form>
        @else
            <span>—</span>
        @endif
    </td>
</tr>
@endforeach
</table>

<div class="stats">
    <div class="stat-card">
        <h3>{{ $reservations->count() }}</h3>
        <p>Total réservations supervisées</p>
    </div>
    <div class="stat-card">
        <h3>{{ $reservations->where('status','pending')->count() }}</h3>
        <p>En attente</p>
    </div>
    <div class="stat-card">
        <h3>{{ $reservations->where('status','active')->count() }}</h3>
        <p>Actives</p>
    </div>
</div>
@endsection