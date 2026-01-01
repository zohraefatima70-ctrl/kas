<?php

// routes/web.php

use Illuminate\Support\Facades\Route;

// Importation des Contrôleurs
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\InternalUserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\IncidentController;
// Import des Contrôleurs Admin (si vous les avez mis dans un sous-dossier Admin)
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ResourceManagementController;
use App\Http\Controllers\Admin\MaintenanceController;
// routes/web.php

use App\Http\Controllers\Auth\LoginController;
// ... (autres imports)

// Routes d'Authentification Manuelles (Login)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login']);

// Route de Déconnexion
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Note : Vous devrez créer un RegistrationController similaire pour l'inscription.