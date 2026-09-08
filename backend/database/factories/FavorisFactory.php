<?php

namespace Database\Factories;

use App\Models\Stagiaire;
use App\Models\Offredestage;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavorisFactory extends Factory
{
    public function definition(): array
    {
        return [
            'idUtilisateur_Stagiaire' => Stagiaire::inRandomOrder()->value('user_id') ?? Stagiaire::factory(),
            'id_Offre_De_Stage' => Offredestage::inRandomOrder()->value('id') ?? Offredestage::factory(),
        ];
    }
}