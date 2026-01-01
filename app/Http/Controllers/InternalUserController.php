<?php

// app/Http/Controllers/InternalUserController.php

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class InternalUserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Récupérer toutes les réservations de l'utilisateur, ordonnées par date
        $myReservations = Reservation::with('resource')
            ->where('user_id', $userId)
            ->orderBy('start_time', 'desc')
            ->get();

        // Filtrer les réservations par statut pour affichage dans la vue
        $pending = $myReservations->where('status', 'pending');
        $approved = $myReservations->where('status', 'approved');
        $active = $myReservations->where('status', 'active');
        $history = $myReservations->whereIn('status', ['rejected', 'completed']);

        // Récupérer les notifications (en utilisant le trait Notifiable par défaut de Laravel)
        $notifications = Auth::user()->unreadNotifications;

        return view('internal.dashboard', compact('pending', 'approved', 'active', 'history', 'notifications'));
    }
}