<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< Updated upstream
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
=======
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
            NotificationSeeder::class,

>>>>>>> Stashed changes
        ]);
    }
}
