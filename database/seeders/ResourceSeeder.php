<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Category;
use App\Models\User; // Pour récupérer le Manager (Fatima TechManager)
use Carbon\Carbon;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        // Vider la table pour un état propre
        Resource::truncate(); 

        // 1. Récupération des IDs et variables
        $manager = User::where('email', 'manager@dcresa.com')->first();
        
        $serverCategory = Category::where('name', 'Serveurs')->first();
        $networkCategory = Category::where('name', 'Équipement Réseau')->first();
        $roomCategory = Category::where('name', 'Salles')->first();
        
        $now = Carbon::now();
        
        // ID du manager (s'il existe, sinon on utilise null ou on s'arrête)
        $managerId = $manager ? $manager->id : null; 
        
        // Sécurité : On ne fait rien si le manager n'existe pas
        if (!$managerId) {
            return; 
        }

        // 2. Ressources 'Serveurs'
        if ($serverCategory) {
            
            // Serveur 1 (DISPO)
            Resource::create([
                'name' => 'Dell PowerEdge R740',
                'description' => 'Serveur physique principal',
                'location' => 'Salle A - Rack 01',
                'status' => 'DISPO',
                'category_id' => $serverCategory->id,
                'manager_id' => $managerId,
                'created_at' => $now, 
                'updated_at' => $now
            ]);
            
            // Serveur 2 (RÉSERVÉ)
            Resource::create([
                'name' => 'VM-Web-Prod',
                'description' => 'Serveur Web production',
                'location' => 'Cluster Proxmox 01',
                'status' => 'RESERVE', 
                'category_id' => $serverCategory->id,
                'manager_id' => $managerId,
                'created_at' => $now, 
                'updated_at' => $now
            ]);
        }
        
        // 3. Ressources 'Équipement Réseau'
        if ($networkCategory) {
            
            // Switch 1 (MAINTENANCE)
            Resource::create([
                'name' => 'Cisco Catalyst 9300',
                'description' => 'Switch coeur de réseau',
                'location' => 'Salle B - Armoire Réseau',
                'status' => 'MAINT',
                'category_id' => $networkCategory->id,
                'manager_id' => $managerId,
                'created_at' => $now, 
                'updated_at' => $now
            ]);
        }
        
        // 4. Ressources 'Salles'
        if ($roomCategory) {
            
            // Salle 1 (DISPO)
            Resource::create([
                'name' => 'Salle de Conférence KAS',
                'description' => 'Salle principale pour les réunions de groupe',
                'location' => '2ème étage',
                'status' => 'DISPO',
                'category_id' => $roomCategory->id,
                'manager_id' => $managerId,
                'created_at' => $now, 
                'updated_at' => $now
            ]);
        }
    }
}