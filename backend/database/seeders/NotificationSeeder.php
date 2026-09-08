<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            foreach (range(1, rand(2, 5)) as $index) {
                Notification::create([
                    'titre' => 'Notification #' . $index,
                    'message' => fake()->realText(100),
                    'lu' => fake()->boolean(30),
                    'date_envoi' => fake()->dateTimeBetween('-2 weeks', 'now'),
                    'id_Utilisateur' => $user->id,
                ]);
            }
        }
    }
}