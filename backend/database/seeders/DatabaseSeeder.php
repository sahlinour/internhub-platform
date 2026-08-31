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
    CompetenceSeeder::class,
    OffredestageSeeder::class,
    PossedeSeeder::class,
    FavorisSeeder::class,
    CandidatureSeeder::class,
    StageSeeder::class,
    EvaluationSeeder::class,
    DocumentSeeder::class,
    TacheSeeder::class,
    SignalementSeeder::class,
    NotificationSeeder::class,
]);
    }
}