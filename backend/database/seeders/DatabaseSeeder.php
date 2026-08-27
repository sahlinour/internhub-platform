<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VilleSeeder::class,
            UserSeeder::class,
            OffredestageSeeder::class,
            CompetenceSeeder::class,
            PossedeSeeder::class,
            FavorisSeeder::class,
            CandidatureSeeder::class,
            SignalementSeeder::class,
            StageSeeder::class,
            EvaluationSeeder::class,
            DocumentSeeder::class,
            TacheSeeder::class,
        ]);
    }
}