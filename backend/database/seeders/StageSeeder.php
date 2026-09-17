<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Encadrant;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    public function run(): void
    {
        // Development supervisor
        $encadrantUser = User::where(
            'email',
            'encadrant1@internhub.ma'
        )->first();

        if (!$encadrantUser) {
            $this->command->error('Encadrant 1 not found.');
            return;
        }

        $encadrant = Encadrant::where(
            'user_id',
            $encadrantUser->id
        )->first();

        if (!$encadrant) {
            $this->command->error('Encadrant profile not found.');
            return;
        }

        // Only candidatures that do not already have a stage
        $candidatures = Candidature::whereDoesntHave('stage')
            ->take(10)
            ->get();

        if ($candidatures->isEmpty()) {
            $this->command->warn(
                'No candidature without a stage was found.'
            );

            return;
        }

        foreach ($candidatures as $index => $candidature) {

            $candidature->update([
                'statut' => 'Acceptée',
            ]);

            $dateDebut = fake()->dateTimeBetween('-2 months', 'now');
            $dateFin = (clone $dateDebut)->modify('+3 months');

            // First 4 stages always belong to Encadrant 1.
            // Remaining stages are distributed randomly.
            $encadrantId = $index < 4
                ? $encadrant->user_id
                : Encadrant::inRandomOrder()->value('user_id');

            Stage::create([
                'sujet' => 'Application Web: ' . fake()->jobTitle(),

                'date_debut' => $dateDebut->format('Y-m-d'),

                'date_fin' => $dateFin->format('Y-m-d'),

                'statut' => 'En cours',

                'idUtilisateur_Encadrant' => $encadrantId,

                'id_Candidature' => $candidature->id,
            ]);
        }

        $this->command->info(
            'Stages seeded successfully.'
        );
    }
}
