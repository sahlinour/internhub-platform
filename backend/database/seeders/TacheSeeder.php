<?php

namespace Database\Seeders;

use App\Models\Stage;
use App\Models\Tache;
use Illuminate\Database\Seeder;

class TacheSeeder extends Seeder
{
    public function run(): void
    {
        $stages = Stage::all();

        if ($stages->isEmpty()) {
            return;
        }

        foreach ($stages as $stage) {
            foreach (range(1, rand(2, 5)) as $index) {
                $dateCreation = fake()->dateTimeBetween('-1 month', 'now');
                $dateEcheance = (clone $dateCreation)->modify('+10 days');
                $statut = fake()->randomElement(['À faire', 'En cours', 'Terminée']);

                Tache::create([
                    'titre' => "Tâche {$index}: " . fake()->bs(),
                    'description' => fake()->paragraph(),
                    'priorite' => fake()->randomElement(['Basse', 'Moyenne', 'Haute']),
                    'date_creation' => $dateCreation->format('Y-m-d'),
                    'date_echeance' => $dateEcheance->format('Y-m-d'),
                    'date_fin_effective' => $statut === 'Terminée' ? (clone $dateCreation)->modify('+5 days')->format('Y-m-d') : null,
                    'statut' => $statut,
                    'idUtilisateur' => $stage->candidature->idUtilisateur_Stagiaire ?? 1,
                    'id_Stage' => $stage->id,
                ]);
            }
        }
    }
}