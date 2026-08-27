<?php

namespace Database\Seeders;

use App\Models\Stage;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        $stages = Stage::all();

        if ($stages->isEmpty()) {
            return;
        }

        foreach ($stages as $stage) {
            $noteTech = fake()->randomFloat(2, 12, 19);
            $noteRel = fake()->randomFloat(2, 12, 19);

            Evaluation::create([
                'type_evaluation'         => 'Finale',
                'note_technique'          => $noteTech,
                'note_relationnelle'      => $noteRel,
                'note_global'             => round(($noteTech + $noteRel) / 2, 2),
                'remarque_encadrant'      => fake()->realText(150),
                'date_evaluation'         => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant,
                'id_Stage'                => $stage->id,
            ]);
        }
    }
}