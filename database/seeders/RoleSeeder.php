<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table des rôles (TABLE PRINCIPALE - peut être vidée maintenant)
        DB::table('roles')->truncate(); 

        $now = Carbon::now();

        DB::table('roles')->insert([
            // ... (Insertion des 4 rôles : Administrateur, Responsable Technique, Utilisateur Interne, Invité)
            [
                'name' => 'Administrateur', 
                'description' => 'Gestion complète...',
                'created_at' => $now, 'updated_at' => $now
            ],
            // ...
        ]);
    }
}