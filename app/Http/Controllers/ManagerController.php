<?php

// app/Http/Controllers/ManagerController.php

use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        $managerId = Auth::id();

        // Ressources supervisées par ce responsable
        $supervisedResources = Resource::where('manager_id', $managerId)->pluck('id');

        // Demandes de réservation en attente pour les ressources qu'il gère
        $pendingRequests = Reservation::with('user', 'resource')
            ->whereIn('resource_id', $supervisedResources)
            ->where('status', 'pending')
            ->orderBy('start_time', 'asc')
            ->get();
            
        // Demandes d'incidents ouvertes pour les ressources qu'il gère
        $openIncidents = Incident::whereIn('resource_id', $supervisedResources)
                                  ->where('status', '!=', 'resolved')
                                  ->get();

        return view('manager.dashboard', compact('pendingRequests', 'openIncidents'));
    }
}