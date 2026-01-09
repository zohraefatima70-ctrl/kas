<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create($resource_id)
    {
        $resource = Resource::with('category')->findOrFail($resource_id);
        
        if($resource->status !== 'active') {
            return redirect()->route('internal.catalogue')->with('error', 'Cette ressource n\'est pas disponible pour la réservation.');
        }

        return view('user.reservations.create', compact('resource'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'reason' => 'nullable|string'
        ]);

        $resource = Resource::findOrFail($request->resource_id);

        // Basic conflict check (simplistic for now)
        $conflict = Reservation::where('resource_id', $resource->id)
            ->whereIn('status', ['approved', 'active'])
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'La ressource est déjà réservée sur ce créneau.');
        }

        Reservation::create([
            'resource_id' => $resource->id,
            'user_id' => Auth::id(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
            'status' => 'pending' // Default status
        ]);

        return redirect()->route('internal.dashboard')->with('success', 'Votre demande de réservation a été enregistrée.');
    }
}