<?php

namespace Database\Seeders;

use App\Models\Stagiaire;
use App\Models\Offredestage;
use App\Models\Favoris;
use Illuminate\Database\Seeder;

class FavorisSeeder extends Seeder
{
    public function run(): void
    {
        $stagiaires = Stagiaire::all();
        $offres = Offredestage::all();

        if ($stagiaires->isEmpty() || $offres->isEmpty()) {
            return;
        }

        foreach ($stagiaires as $stagiaire) {
            // Sélectionne des offres aléatoires uniques
            $randomOffres = $offres->random(rand(1, min(4, $offres->count())));

            foreach ($randomOffres as $offre) {
                Favoris::firstOrCreate([
                    'idUtilisateur_Stagiaire' => $stagiaire->user_id,
                    'id_Offre_De_Stage' => $offre->id,
                ]);
            }
        }
    }
}