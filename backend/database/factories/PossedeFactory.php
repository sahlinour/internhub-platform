<?php

namespace Database\Factories;

use App\Models\Competence;
use App\Models\Stagiaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class PossedeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_Competence' => Competence::inRandomOrder()->value('id') ?? Competence::factory(),
            'idUtilisateur_Stagiaire' => Stagiaire::inRandomOrder()->value('user_id') ?? Stagiaire::factory(),
            'niveau' => fake()->randomElement(['Débutant', 'Intermédiaire', 'Avancé', 'Expert']),
            'experience' => fake()->randomElement(['< 1 ans', '1-2 ans', '3+ ans']),
            'date_ajout' => fake()->date(),
        ];
    }
}