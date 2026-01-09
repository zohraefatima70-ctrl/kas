<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $managerId = Auth::id();
        $supervisedResourcesIds = Resource::where('manager_id', $managerId)->pluck('id');

        $pendingRequests = Reservation::with('user', 'resource')
            ->whereIn('resource_id', $supervisedResourcesIds)
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        $myResourcesCount = Resource::where('manager_id', $managerId)->count();
        $activeReservationsCount = Reservation::whereIn('resource_id', $supervisedResourcesIds)
            ->where('status', 'active')
            ->count();

        return view('manager.dashboard', compact('pendingRequests', 'myResourcesCount', 'activeReservationsCount'));
    }

    public function approveReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Ensure the manager supervises this resource
        if ($reservation->resource->manager_id != Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à gérer cette réservation.');
        }

        $reservation->update(['status' => 'approved']);
        
        // Notification logic would go here

        return back()->with('success', 'Réservation approuvée.');
    }

    public function rejectReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->resource->manager_id != Auth::id()) {
            return back()->with('error', 'Interdit.');
        }

        $reservation->update(['status' => 'rejected']);

        return back()->with('success', 'Réservation refusée.');
    }

    public function myResources()
    {
        $resources = Resource::where('manager_id', Auth::id())
            ->with(['category', 'activeReservation'])
            ->paginate(10);

        return view('manager.resources', compact('resources'));
    }
}
