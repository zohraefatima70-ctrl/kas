<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Ajoutez cet import pour truncate si vous utilisez le Facade

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table des utilisateurs (TABLE DÉPENDANTE - doit être vidée en premier)
        User::truncate(); 
        // OU DB::table('users')->truncate(); si vous préférez la Facade

        // ... Le reste du code pour trouver les rôles et créer les utilisateurs...

        $adminRole = Role::where('name', 'Administrateur')->first();
        $managerRole = Role::where('name', 'Responsable Technique')->first();
        $internalRole = Role::where('name', 'Utilisateur Interne')->first();

        // Création des utilisateurs (Identifiants : admin@dcresa.com / password)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@dcresa.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id ?? null,
        ]);
        // ... (autres créations d'utilisateurs)
    }
}