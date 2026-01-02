<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // obligatoire !
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // ta vue login
    }

    /**
     * Traiter la connexion.
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection selon rôle et statut
            return $this->redirectByRole(Auth::user());
        }

        // Login échoué
        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
    }

    /**
     * Déconnexion.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirection selon rôle et statut.
     */
    protected function redirectByRole($user)
    {
        // Vérifier si le compte est actif
        if ($user->status != 'active') {
            Auth::logout();
            return redirect()->route('login')->withErrors('Votre compte n’est pas actif.');
        }

        // Redirection selon rôle
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'responsable':
                return redirect()->route('manager.dashboard');
            case 'utilisateur':
                return redirect()->route('user.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors('Rôle non reconnu.');
        }
    }
}