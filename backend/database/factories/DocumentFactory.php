<?php

namespace Database\Factories;

use App\Models\Encadrant;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        $documentTypes = ['Rapport_de_stage', 'Convention_de_stage', 'Fiche_d_evaluation', 'Livrable_projet'];
        $fileName = fake()->randomElement($documentTypes) . '_' . fake()->uuid() . '.pdf';

        return [
            'nom'                     => $fileName,
            'version'                 => 'v' . fake()->numberBetween(1, 3) . '.' . fake()->numberBetween(0, 9),
            'statut'                  => fake()->randomElement(['En attente', 'Validé', 'Rejeté']),
            'fichier_url'             => 'documents/' . $fileName,
            'idUtilisateur_Encadrant' => Encadrant::inRandomOrder()->value('user_id') ?? Encadrant::factory(),
            'id_Stage'                => Stage::inRandomOrder()->value('id') ?? Stage::factory(),
        ];
    }
}