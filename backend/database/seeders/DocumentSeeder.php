<?php

namespace Database\Seeders;

use App\Models\Stage;
use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $stages = Stage::all();

        if ($stages->isEmpty()) {
            return;
        }

        foreach ($stages as $stage) {
            // Attach 1 to 3 documents per stage
            foreach (range(1, rand(1, 3)) as $index) {
                $fileName = "Rapport_Etape_{$index}_" . fake()->word() . ".pdf";

                Document::create([
                    'nom'                      => $fileName,
                    'version'                  => "v{$index}.0",
                    'statut'                   => fake()->randomElement(['En attente', 'Validé', 'Rejeté']),
                    'fichier_url'              => "documents/{$fileName}",
                    'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant ?? 1,
                    'id_Stage'                 => $stage->id,
                ]);
            }
        }
    }
}