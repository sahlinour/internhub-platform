<?php

namespace Database\Factories;

use App\Models\Stagiaire;
use App\Models\Offredestage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'statut' => fake()->randomElement(['En attente', 'En cours d\'examen', 'Acceptée', 'Refusée']),
            'date_postulation' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'lettre_de_motivation' => fake()->paragraphs(2, true),
            'piece_jointe' => 'documents/attachments/' . fake()->uuid() . '.pdf',
            'cv_url' => 'documents/cvs/' . fake()->uuid() . '.pdf',
            'idUtilisateur_Stagiaire' => Stagiaire::inRandomOrder()->value('user_id') ?? Stagiaire::factory(),
            'id_Offre_De_Stage' => Offredestage::inRandomOrder()->value('id') ?? Offredestage::factory(),
        ];
    }
}