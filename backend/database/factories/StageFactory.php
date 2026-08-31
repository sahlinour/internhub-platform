<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\Encadrant;
use Illuminate\Database\Eloquent\Factories\Factory;

class StageFactory extends Factory
{
    public function definition(): array
    {
        $dateDebut = fake()->dateTimeBetween('-3 months', 'now');
        $dateFin = (clone $dateDebut)->modify('+3 months');

        return [
            'sujet' => fake()->sentence(4),
            'date_debut' => $dateDebut->format('Y-m-d'),
            'date_fin' => $dateFin->format('Y-m-d'),
            'statut' => fake()->randomElement(['En cours', 'Terminé', 'Annulé']),
            'idUtilisateur_Encadrant' => Encadrant::inRandomOrder()->value('user_id'),
            'id_Candidature' => Candidature::factory(),
        ];
    }
}