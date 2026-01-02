<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Vider la table des utilisateurs 
        User::truncate(); 

        // 2. Récupération des IDs des Rôles
        $adminRole = Role::where('name', 'Administrateur')->first();
        $managerRole = Role::where('name', 'Responsable Technique')->first();
        $internalRole = Role::where('name', 'Utilisateur Interne')->first();
        
        $now = Carbon::now();

        // 3. Insertion des Utilisateurs
        
        // ADMINISTRATEUR (admin@dcresa.com / password)
        if ($adminRole) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@dcresa.com', 
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'created_at' => $now, 
                'updated_at' => $now
            ]);
        }
        
        // RESPONSABLE TECHNIQUE (manager@dcresa.com / password)
        if ($managerRole) {
            User::create([
                'name' => 'Fatima TechManager',
                'email' => 'manager@dcresa.com',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
                'created_at' => $now, 
                'updated_at' => $now
            ]);
        }

        // UTILISATEURS INTERNES (Standard)
        if ($internalRole) {
            $internalUsers = [
                // Utilisateur initial
                ['name' => 'romaissae', 'email' => 'user@dcresa.com'],
                // Utilisateurs supplémentaires
                ['name' => 'salmane', 'email' => 'interne1@dcresa.com'],
                ['name' => 'zakaria', 'email' => 'interne2@dcresa.com'],
            ];

            foreach ($internalUsers as $userData) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'), // Même mot de passe de test
                    'role_id' => $internalRole->id,
                    'created_at' => $now, 
                    'updated_at' => $now
                ]);
            }
        }
    }
}