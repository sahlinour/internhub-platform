<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offredestage;
use App\Models\Entreprise;
use App\Models\User;

class OffredestageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure at least one Enterprise/User exists for foreign key constraint
        $entreprise = Entreprise::first();

        if (!$entreprise) {
            $user = User::factory()->create([
                'role' => 'entreprise',
            ]);
            
            $entreprise = Entreprise::create([
                'user_id' => $user->id,
                'nom_entreprise' => 'TechCorp Morocco',
                'secteur' => 'Software Engineering',
            ]);
        }

        $userId = $entreprise->user_id;

        // 2. Insert sample internship offers with required_skills array
        $offers = [
            [
                'titre' => 'Full Stack Developer Intern (Node.js / Vue.js)',
                'description' => 'We are seeking a motivated Full Stack Intern to help build backend REST APIs in Node.js and user interfaces in Vue.js. Experience using Figma for UI components is a major plus.',
                'duree' => '6 months',
                'date_limite' => now()->addDays(45),
                'statut' => 'active',
                'required_skills' => ['Node.js', 'Express', 'Vue.js', 'Figma', 'PostgreSQL', 'REST APIs'],
                'idUtilisateur_Entreprise' => $userId,
            ],
            [
                'titre' => 'UI/UX Design & Prototyping Intern',
                'description' => 'Join our product team to design user interfaces and wireframes in Figma. You will work closely with frontend developers who use Vue.js and Node.js.',
                'duree' => '3 months',
                'date_limite' => now()->addDays(30),
                'statut' => 'active',
                'required_skills' => ['Figma', 'UI/UX', 'Wireframing', 'Prototyping', 'Tailwind CSS'],
                'idUtilisateur_Entreprise' => $userId,
            ],
            [
                'titre' => 'Backend Node.js Microservices Intern',
                'description' => 'Looking for a Backend Intern passionate about server-side architecture. You will develop APIs with Node.js, Express, and PostgreSQL, containerized with Docker.',
                'duree' => '6 months',
                'date_limite' => now()->addDays(60),
                'statut' => 'active',
                'required_skills' => ['Node.js', 'Express.js', 'PostgreSQL', 'Docker', 'REST APIs', 'Git'],
                'idUtilisateur_Entreprise' => $userId,
            ],
            [
                'titre' => 'Frontend Vue.js Developer Intern',
                'description' => 'We need an intern to turn Figma design mockups into responsive Vue.js web pages using Tailwind CSS and connecting them to Node.js backend services.',
                'duree' => '4 months',
                'date_limite' => now()->addDays(20),
                'statut' => 'active',
                'required_skills' => ['Vue.js', 'JavaScript', 'Tailwind CSS', 'Figma', 'HTML/CSS'],
                'idUtilisateur_Entreprise' => $userId,
            ],
        ];

        foreach ($offers as $offer) {
            Offredestage::create($offer);
        }
    }
}