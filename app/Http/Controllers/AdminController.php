<?php

// app/Http/Controllers/AdminController.php

use App\Models\Resource;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Statistiques Globales
        $totalResources = Resource::count();
        $totalUsers = User::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        
        // 2. Taux d'Occupation (Exemple simplifié)
        // Calculer l'utilisation réelle est complexe et sera fait via des requêtes d'agrégation dans une étape ultérieure,
        // mais pour le dashboard initial, on peut calculer le nombre de ressources actives/occupées.
        $activeReservations = Reservation::where('status', 'active')->count();
        
        // 3. Répartition des utilisateurs par rôle
        $usersByRole = User::join('roles', 'users.role_id', '=', 'roles.id')
                            ->select('roles.name', DB::raw('count(*) as count'))
                            ->groupBy('roles.name')
                            ->pluck('count', 'roles.name');

        // Préparation des données pour la vue du tableau de bord.
        $stats = [
            'totalResources' => $totalResources,
            'totalUsers' => $totalUsers,
            'pendingReservations' => $pendingReservations,
            'activeReservations' => $activeReservations,
            'usersByRole' => $usersByRole,
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}