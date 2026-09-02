<?php

namespace Database\Factories;

use App\Models\Encadrant;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

class TacheFactory extends Factory
{
    public function definition(): array
    {
        $dateCreation = fake()->dateTimeBetween('-2 months', 'now');
        $dateEcheance = (clone $dateCreation)->modify('+2 weeks');
        $statut = fake()->randomElement(['À faire', 'En cours', 'Terminée', 'Annulée']);
        $dateFin = $statut === 'Terminée' ? (clone $dateCreation)->modify('+1 week')->format('Y-m-d') : null;

        return [
            'titre'                   => fake()->sentence(4),
            'description'             => fake()->paragraph(),
            'priorite'                => fake()->randomElement(['Basse', 'Moyenne', 'Haute', 'Urgente']),
            'date_creation'           => $dateCreation->format('Y-m-d'),
            'date_echeance'           => $dateEcheance->format('Y-m-d'),
            'date_fin_effective'      => $dateFin,
            'statut'                  => $statut,
            'idUtilisateur_Encadrant' => Encadrant::inRandomOrder()->value('user_id') ?? Encadrant::factory(),
            'id_Stage'                => Stage::inRandomOrder()->value('id') ?? Stage::factory(),
        ];
    }
}