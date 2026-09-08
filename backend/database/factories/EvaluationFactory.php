<?php

namespace Database\Factories;

use App\Models\Stage;
use App\Models\Encadrant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    public function definition(): array
    {
        $noteTech = fake()->randomFloat(2, 10, 20);
        $noteRel = fake()->randomFloat(2, 10, 20);
        $noteGlobal = round(($noteTech + $noteRel) / 2, 2);

        return [
            'type_evaluation' => fake()->randomElement(['Mi-parcours', 'Finale', 'Hebdomadaire']),
            'note_technique' => $noteTech,
            'note_relationnelle' => $noteRel,
            'note_global' => $noteGlobal,
            'remarque_encadrant' => fake()->paragraph(),
            'date_evaluation' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'idUtilisateur_Encadrant' => Encadrant::inRandomOrder()->value('user_id'),
            'id_Stage' => Stage::inRandomOrder()->value('id') ?? Stage::factory(),
        ];
    }
}