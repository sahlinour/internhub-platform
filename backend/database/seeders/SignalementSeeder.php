<?php

namespace Database\Seeders;

use App\Models\Signalement;
use Illuminate\Database\Seeder;

class SignalementSeeder extends Seeder
{
    public function run(): void
    {
        Signalement::factory()->count(15)->create();
    }
}