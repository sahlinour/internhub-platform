<?php

namespace Database\Seeders;

use App\Models\Offredestage;
use Illuminate\Database\Seeder;

class OffredestageSeeder extends Seeder
{
    public function run(): void
    {
        // Génère 20 enregistrements de test
        Offredestage::factory()->count(20)->create();
    }
}