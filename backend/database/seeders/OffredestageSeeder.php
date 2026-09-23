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
        // 1. Ensure at least one Enterprise/User exists
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

        // 2. Internship offers
        $offers = [
            [
                'titre' => 'Full Stack Developer Intern',
                'description' => 'Join our development team to build modern web applications using Laravel, Vue.js and PostgreSQL.',
                'duree' => '6 months',
                'date_limite' => now()->addDays(45),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Laravel',
                    'Vue.js',
                    'PHP',
                    'PostgreSQL',
                    'Git',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Frontend Vue.js Developer Intern',
                'description' => 'Develop responsive and interactive user interfaces using Vue.js and Tailwind CSS.',
                'duree' => '4 months',
                'date_limite' => now()->addDays(30),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Vue.js',
                    'JavaScript',
                    'Tailwind CSS',
                    'HTML/CSS',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Backend Laravel Developer Intern',
                'description' => 'Participate in the development of backend features, database management and RESTful services with Laravel.',
                'duree' => '6 months',
                'date_limite' => now()->addDays(50),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Laravel',
                    'PHP',
                    'MySQL',
                    'PostgreSQL',
                    'REST API',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Python & FastAPI Developer Intern',
                'description' => 'Develop backend services and APIs using Python and FastAPI in a modern software environment.',
                'duree' => '5 months',
                'date_limite' => now()->addDays(40),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Python',
                    'FastAPI',
                    'REST API',
                    'PostgreSQL',
                    'Git',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'UI/UX Design Intern',
                'description' => 'Create user interfaces, wireframes and interactive prototypes while collaborating with the development team.',
                'duree' => '3 months',
                'date_limite' => now()->addDays(25),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Figma',
                    'UI/UX',
                    'Wireframing',
                    'Prototyping',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Data Science Intern',
                'description' => 'Work on data preparation, analysis and visualization tasks using Python and common data science tools.',
                'duree' => '4 months',
                'date_limite' => now()->addDays(35),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Python',
                    'Pandas',
                    'Data Analysis',
                    'SQL',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Artificial Intelligence Intern',
                'description' => 'Participate in the development and integration of artificial intelligence features into web applications.',
                'duree' => '6 months',
                'date_limite' => now()->addDays(55),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Python',
                    'Machine Learning',
                    'AI',
                    'FastAPI',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'DevOps & Docker Intern',
                'description' => 'Assist the development team in containerization, deployment automation and development environment management.',
                'duree' => '5 months',
                'date_limite' => now()->addDays(42),
                'statut' => 'ouverte',
                'required_skills' => [
                    'Docker',
                    'Docker Compose',
                    'Linux',
                    'Git',
                    'CI/CD',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Mobile Application Developer Intern',
                'description' => 'Participate in the development of modern mobile application interfaces and features.',
                'duree' => '4 months',
                'date_limite' => now()->addDays(60),
                'statut' => 'en_attente',
                'required_skills' => [
                    'Flutter',
                    'Dart',
                    'Mobile Development',
                    'Git',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Software Testing Intern',
                'description' => 'Participate in functional and automated testing activities and help improve software quality.',
                'duree' => '3 months',
                'date_limite' => now()->addDays(20),
                'statut' => 'en_attente',
                'required_skills' => [
                    'Testing',
                    'PHPUnit',
                    'Vitest',
                    'Quality Assurance',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Web Developer Intern',
                'description' => 'Contribute to the development and maintenance of web applications within a collaborative development team.',
                'duree' => '6 months',
                'date_limite' => now()->subDays(10),
                'statut' => 'fermee',
                'required_skills' => [
                    'PHP',
                    'JavaScript',
                    'HTML/CSS',
                    'Git',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],

            [
                'titre' => 'Database Developer Intern',
                'description' => 'Assist in database design, SQL queries, data management and database optimization activities.',
                'duree' => '4 months',
                'date_limite' => now()->subDays(5),
                'statut' => 'fermee',
                'required_skills' => [
                    'PostgreSQL',
                    'SQL',
                    'Database Design',
                    'Data Modeling',
                ],
                'idUtilisateur_Entreprise' => $userId,
            ],
        ];

        foreach ($offers as $offer) {
            Offredestage::create($offer);
        }
    }
}