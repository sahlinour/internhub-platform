<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Encadrant;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    public function run(): void
    {
        $candidatures = Candidature::whereDoesntHave('stage')->get();

        if ($candidatures->isEmpty()) {
            return;
        }

        foreach ($candidatures->take(10) as $candidature) {
            $candidature->update(['statut' => 'Acceptée']);

            $dateDebut = fake()->dateTimeBetween('-3 months', 'now');
            $dateFin = (clone $dateDebut)->modify('+3 months');

            Stage::create([
                'sujet'                   => 'Application Web: ' . fake()->jobTitle(),
                'date_debut'              => $dateDebut->format('Y-m-d'),
                'date_fin'                => $dateFin->format('Y-m-d'),
                'statut'                  => fake()->randomElement(['En cours', 'Terminé']),
                'idUtilisateur_Encadrant' => Encadrant::inRandomOrder()->value('user_id'),
                'id_Candidature'          => $candidature->id,
            ]);
        }
    }
}