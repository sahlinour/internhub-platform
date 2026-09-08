<?php

namespace Database\Factories;

use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffredestageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => fake()->jobTitle(),
            'description' => fake()->paragraphs(2, true),
            'duree' => fake()->randomElement(['2 mois', '3 mois', '4 mois', '6 mois']),
            'date_limite' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'statut' => fake()->randomElement(['Ouverte', 'Fermée', 'En attente']),
            
            // Associe aléatoirement l'offre à un user_id d'une entreprise existante
            'idUtilisateur_Entreprise' => Entreprise::inRandomOrder()->value('user_id'),
        ];
    }
}