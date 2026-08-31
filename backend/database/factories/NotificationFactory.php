<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(3),
            'message' => fake()->paragraph(),
            'lu' => fake()->boolean(40), 
            'date_envoi' => fake()->dateTimeBetween('-1 month', 'now'),
            'id_Utilisateur' => User::inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}