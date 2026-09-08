<?php

namespace Database\Seeders;

use App\Models\Stagiaire;
use App\Models\Offredestage;
use App\Models\Candidature;
use Illuminate\Database\Seeder;

class CandidatureSeeder extends Seeder
{
    public function run(): void
    {
        $stagiaires = Stagiaire::all();
        $offres = Offredestage::all();

        if ($stagiaires->isEmpty() || $offres->isEmpty()) {
            return;
        }

        foreach ($stagiaires as $stagiaire) {
            // Chaque stagiaire postule à 1 à 3 offres aléatoires
            $randomOffres = $offres->random(rand(1, min(3, $offres->count())));

            foreach ($randomOffres as $offre) {
                Candidature::firstOrCreate(
                    [
                        'idUtilisateur_Stagiaire' => $stagiaire->user_id,
                        'id_Offre_De_Stage' => $offre->id,
                    ],
                    [
                        'statut' => fake()->randomElement(['En attente', 'En cours d\'examen', 'Acceptée', 'Refusée']),
                        'date_postulation' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                        'lettre_de_motivation' => fake()->paragraphs(2, true),
                        'piece_jointe' => 'storage/candidatures/motivation.pdf',
                        'cv_url' => 'storage/cvs/stagiaire_cv.pdf',
                    ]
                );
            }
        }
    }
}