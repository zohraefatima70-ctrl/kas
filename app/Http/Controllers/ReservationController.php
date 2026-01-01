<?php

// app/Http/Controllers/ReservationController.php

use App\Models\Reservation;
use App\Models\Maintenance;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    /**
     * Soumet une nouvelle demande de réservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'justification' => 'required|string|max:500',
        ]);

        $resourceId = $validated['resource_id'];
        $startTime = $validated['start_time'];
        $endTime = $validated['end_time'];

        // --- Logique 1: Vérification des Réservations existantes ---
        $existingReservation = Reservation::where('resource_id', $resourceId)
            ->whereIn('status', ['approved', 'active']) 
            ->where(function ($query) use ($startTime, $endTime) {
                // Conflit si le nouveau temps chevauche l'existant
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->exists();

        // --- Logique 2: Vérification de la Maintenance ---
        $conflictingMaintenance = Maintenance::where('resource_id', $resourceId)
            ->where(function ($query) use ($startTime, $endTime) {
                // Conflit avec la maintenance
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
            })
            ->exists();
        
        // Si un conflit est trouvé
        if ($existingReservation || $conflictingMaintenance) {
            throw ValidationException::withMessages([
                'start_time' => 'La ressource est indisponible pendant cette période en raison d\'une réservation existante ou d\'une maintenance planifiée.',
            ]);
        }

        // Création de la demande (statut par défaut: pending)
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $resourceId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'justification' => $validated['justification'],
            'status' => 'pending', 
        ]);
        
        // Notification au Responsable Technique (À implémenter dans la prochaine étape)
        // $resource->manager->notify(new NewReservationRequest($reservation));

        return redirect()->route('internal.dashboard')->with('success', 'Demande de réservation soumise. En attente d\'approbation.');
    }
}