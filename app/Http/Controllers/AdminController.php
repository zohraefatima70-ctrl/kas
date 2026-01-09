<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques globales.
     */
    public function dashboard()
    {
        // 1. Statistiques Globales
        $totalResources = Resource::count();
        $totalUsers = User::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        
        // 2. Taux d'Occupation (Ressources actuellement utilisées)
        $activeReservations = Reservation::where('status', 'active')->count();
        
        // 3. Répartition des utilisateurs par rôle
        $usersByRole = User::join('roles', 'users.role_id', '=', 'roles.id')
                            ->select('roles.name', DB::raw('count(*) as count'))
                            ->groupBy('roles.name')
                            ->pluck('count', 'roles.name');

        // 4. Incidents et Catégories
        // Utilisation de count() directement si les modèles existent, sinon 0 ou placeholders
        // On suppose que les modèles existent comme vérifié précédemment
        try {
            $pendingIncidents = \App\Models\Incident::where('status', '!=', 'resolved')->count();
        } catch (\Exception $e) {
            $pendingIncidents = 0;
        }

        try {
             $totalCategories = \App\Models\Category::count();
        } catch (\Exception $e) {
             $totalCategories = 0;
        }

        // 5. Demandes de compte en attente
        $pendingRequests = \App\Models\AccountRequest::where('status', 'pending')->get();

        $stats = [
            'totalResources' => $totalResources,
            'totalUsers' => $totalUsers,
            'pendingReservations' => $pendingReservations,
            'activeReservations' => $activeReservations,
            'usersByRole' => $usersByRole,
            'pendingIncidents' => $pendingIncidents,
            'totalCategories' => $totalCategories,
        ];
        
        return view('admin.dashboard', compact('stats', 'pendingRequests'));
    }

    public function approveRequest($id)
    {
        $request = \App\Models\AccountRequest::findOrFail($id);

        // Vérifier si l'email existe déjà
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'Un utilisateur avec cet email existe déjà.');
        }

        // Trouver le rôle
        $role = \App\Models\Role::where('name', $request->role)->first();
        if (!$role) {
            return back()->with('error', "Le rôle '{$request->role}' demandé n'existe pas.");
        }

        // Créer l'utilisateur
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password123'), // Mot de passe par défaut
            'role_id' => $role->id,
            'status' => 'active',
        ]);

        // Mettre à jour la demande
        $request->update(['status' => 'approved']);

        return back()->with('success', "Compte approuvé pour {$request->name}. Mot de passe par défaut : password123");
    }

    public function rejectRequest($id)
    {
        $request = \App\Models\AccountRequest::findOrFail($id);
        $request->update(['status' => 'refused']); // Ou delete() si on ne veut pas garder l'historique

        return back()->with('success', 'Demande refusée.');
    }

    public function users()
    {
        $users = User::with('role')->paginate(10);
        $roles = \App\Models\Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
             return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }
        
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with('success', "Statut de l'utilisateur mis à jour.");
    }

    public function updateUserRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $validated['role_id'];
        $user->save();

        return back()->with('success', "Rôle de l'utilisateur mis à jour.");
    }

    // --- Gestion des Ressources ---

    public function resources()
    {
        $resources = Resource::with(['category', 'manager'])->paginate(10);
        return view('admin.resources.index', compact('resources'));
    }

    public function createResource()
    {
        $categories = \App\Models\Category::all();
        $managers = User::whereHas('role', function($q) {
            $q->where('name', 'Responsable Technique'); // Ou tout autre logique pour définir les managers
        })->get();
        return view('admin.resources.create', compact('categories', 'managers'));
    }

    public function storeResource(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,maintenance,inactive', // Ajuster selon les values de l'ENUM
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'cpu_cores' => 'nullable|integer',
            'ram_gb' => 'nullable|integer',
            'storage_tb' => 'nullable|integer',
            'os_name' => 'nullable|string',
        ]);

        Resource::create($validated);

        return redirect()->route('admin.resources.index')->with('success', 'Ressource créée avec succès.');
    }

    public function editResource($id)
    {
        $resource = Resource::findOrFail($id);
        $categories = \App\Models\Category::all();
        $managers = User::whereHas('role', function($q) {
            $q->where('name', 'Responsable Technique');
        })->get();
        return view('admin.resources.edit', compact('resource', 'categories', 'managers'));
    }

    public function updateResource(Request $request, $id)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,maintenance,inactive',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
             'cpu_cores' => 'nullable|integer',
            'ram_gb' => 'nullable|integer',
            'storage_tb' => 'nullable|integer',
            'os_name' => 'nullable|string',
        ]);

        $resource = Resource::findOrFail($id);
        $resource->update($validated);

         return redirect()->route('admin.resources.index')->with('success', 'Ressource mise à jour.');
    }
    // --- Gestion des Catégories ---

    public function categories()
    {
        $categories = \App\Models\Category::withCount('resources')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        \App\Models\Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée.');
    }

    public function editCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category = \App\Models\Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroyCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        if ($category->resources()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des ressources.');
        }

        $category->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }

    // --- Gestion des Maintenances ---

    public function maintenances()
    {
        $maintenances = \App\Models\Maintenance::with('resource')->orderBy('start_time', 'desc')->paginate(10);
        return view('admin.maintenances.index', compact('maintenances'));
    }

    public function createMaintenance()
    {
        $resources = Resource::all();
        return view('admin.maintenances.create', compact('resources'));
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'reason' => 'required|string',
        ]);

        $maintenance = \App\Models\Maintenance::create([
            'resource_id' => $validated['resource_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'reason' => $validated['reason'],
            'status' => 'scheduled',
        ]);

        // Optionnel : Mettre la ressource en maintenance si la date est maintenant
        if (strtotime($validated['start_time']) <= time()) {
            $resource = Resource::find($validated['resource_id']);
            $resource->update(['status' => 'maintenance']);
            $maintenance->update(['status' => 'in_progress']);
        }

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance planifiée.');
    }
}