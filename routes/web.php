<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT DES CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\HomeController;

// Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Utilisateur interne
use App\Http\Controllers\InternalUserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\IncidentController;

// Responsable
use App\Http\Controllers\ManagerController;

// Admin
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ResourceManagementController;
use App\Http\Controllers\Admin\MaintenanceController;

/*
|--------------------------------------------------------------------------
| ROUTES INVITÉ (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/resources', [HomeController::class, 'resources'])->name('resources.list');

// Inscription
Route::get('/register', [RegisterController::class, 'showForm'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| UTILISATEUR INTERNE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:utilisateur'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [InternalUserController::class, 'dashboard'])
        ->name('dashboard');

    // Réservations utilisateur
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Incidents
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
});

/*
|--------------------------------------------------------------------------
| RESPONSABLE TECHNIQUE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:responsable'])->prefix('manager')->name('manager.')->group(function () {

    Route::get('/dashboard', [ManagerController::class, 'dashboard'])
        ->name('dashboard');

    // Voir toutes les réservations supervisées
    Route::get('/reservations', [ReservationController::class, 'indexManager'])->name('reservations.index');

    // Actions sur les réservations
    Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])
        ->name('reservations.approve');
    Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])
        ->name('reservations.reject');

    // Gestion incidents supervisés
    Route::get('/incidents', [IncidentController::class, 'indexManager'])->name('incidents.index');
    Route::post('/incidents/{id}/resolve', [IncidentController::class, 'resolve'])->name('incidents.resolve');
});

/*
|--------------------------------------------------------------------------
| ADMINISTRATEUR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Utilisateurs
    Route::resource('/users', UserController::class);

    // Catégories de ressources
    Route::resource('/categories', CategoryController::class);

    // Gestion des ressources
    Route::resource('/resources', ResourceManagementController::class);

    // Maintenance
    Route::resource('/maintenances', MaintenanceController::class);

    // Actions spécifiques
    Route::post('/resources/{id}/activate', [ResourceManagementController::class, 'activate'])->name('resources.activate');
    Route::post('/resources/{id}/deactivate', [ResourceManagementController::class, 'deactivate'])->name('resources.deactivate');
});
