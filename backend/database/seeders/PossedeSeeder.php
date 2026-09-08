<?php

namespace Database\Seeders;

use App\Models\Competence;
use App\Models\Stagiaire;
use App\Models\Possede;
use Illuminate\Database\Seeder;

class PossedeSeeder extends Seeder
{
    public function run(): void
    {
        $stagiaires = Stagiaire::all();
        $competences = Competence::all();

        if ($stagiaires->isEmpty() || $competences->isEmpty()) {
            return;
        }

        // Associe entre 1 et 3 compétences uniques à chaque stagiaire
        foreach ($stagiaires as $stagiaire) {
            $randomCompetences = $competences->random(min(rand(1, 3), $competences->count()));

            foreach ($randomCompetences as $competence) {
                Possede::create([
                    'id_Competence' => $competence->id,
                    'idUtilisateur_Stagiaire' => $stagiaire->user_id,
                    'niveau' => fake()->randomElement(['Débutant', 'Intermédiaire', 'Avancé', 'Expert']),
                    'experience' => fake()->randomElement(['< 1 an', '1-2 ans', '3+ ans']),
                    'date_ajout' => fake()->date(),
                ]);
            }
        }
    }
}