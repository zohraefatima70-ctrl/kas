<?php

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $roleName = Auth::user()->role->name ?? 'Invité'; // Fallback Invité

            return match ($roleName) {
                'Administrateur' => redirect()->route('admin.dashboard'),
                'Responsable Technique' => redirect()->route('manager.dashboard'),
                'Utilisateur Interne' => redirect()->route('internal.dashboard'),
                default => redirect()->route('resource.list'), // Invité ou rôle inconnu
            };
        }
        return redirect()->route('login');
    }
}
