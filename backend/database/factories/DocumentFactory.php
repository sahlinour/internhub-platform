<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        $documentTypes = ['Rapport_de_stage', 'Convention_de_stage', 'Fiche_d_evaluation', 'Livrable_projet'];
        
        return [
            'nom' => fake()->randomElement($documentTypes) . '_' . fake()->uuid() . '.pdf',
            'version' => 'v' . fake()->numberBetween(1, 3) . '.' . fake()->numberBetween(0, 9),
            'statut' => fake()->randomElement(['En attente', 'Validé', 'Rejeté']),
            'idUtilisateur' => User::inRandomOrder()->value('id') ?? User::factory(),
            'id_Stage' => Stage::inRandomOrder()->value('id') ?? Stage::factory(),
        ];
    }
}