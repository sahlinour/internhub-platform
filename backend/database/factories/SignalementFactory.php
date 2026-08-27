<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Offredestage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignalementFactory extends Factory
{
    public function definition(): array
    {
        $statut = fake()->randomElement(['En attente', 'Traité', 'Rejeté']);

        return [
            'raison' => fake()->randomElement([
                'Offre frauduleuse ou trompeuse',
                'Contenu inapproprié ou injurieux',
                'Entreprise non joignable',
                'Non-respect des conditions de stage'
            ]),
            'date_signalement' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'statut' => $statut,
            'idUtilisateur_emetteur' => User::inRandomOrder()->value('id') ?? User::factory(),
            'id_Utilisateur_Admin' => $statut === 'En attente' ? null : 1,
            'id_Offre_De_Stage' => Offredestage::inRandomOrder()->value('id') ?? Offredestage::factory(),
        ];
    }
}