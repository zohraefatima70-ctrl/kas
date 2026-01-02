<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        // On vide la table pour repartir à neuf
        DB::table('resources')->truncate();

        // On récupère les IDs nécessaires pour les relations
        $catServeur = Category::where('name', 'Serveur')->first()->id;
        $catVM = Category::where('name', 'Machine Virtuelle')->first()->id;
        $catReseau = Category::where('name', 'Équipement Réseau')->first()->id;
        
        // On récupère l'ID du premier utilisateur (souvent l'admin) pour manager_id
        $adminId = User::first()->id;

        $resources = [
            [
                'name' => 'Dell PowerEdge R740',
                'category_id' => $catServeur,
                'manager_id' => $adminId,
                'location' => 'Salle A - Rack 01',
                'status' => 'disponible',
                'description' => 'Serveur physique principal',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'VM-Web-Prod',
                'category_id' => $catVM,
                'manager_id' => $adminId,
                'location' => 'Cluster Proxmox 01',
                'status' => 'disponible',
                'description' => 'Serveur Web production',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Cisco Catalyst 9300',
                'category_id' => $catReseau,
                'manager_id' => $adminId,
                'location' => 'Salle B - Armoire Réseau',
                'status' => 'maintenance',
                'description' => 'Switch coeur de réseau',
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('resources')->insert($resources);
    }
}