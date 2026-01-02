<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * L'aiguilleur central après connexion.
     */
    public function index()
    {
        $user = Auth::user();
        $roleName = $user->role->name; // Assurez-vous que la relation 'role' est définie sur votre modèle User

        if ($roleName === 'Administrateur') {
            return redirect()->route('admin.dashboard');
        } elseif ($roleName === 'Responsable Technique') {
            return redirect()->route('manager.dashboard');
        } elseif ($roleName === 'Utilisateur Interne') {
            return redirect()->route('user.dashboard');
        } else {
            // Rôle Invité ou autre
            return redirect('/');
        }
    }
}