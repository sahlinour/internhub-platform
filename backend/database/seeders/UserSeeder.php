<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ville;
use App\Models\Entreprise;
use App\Models\Encadrant;
use App\Models\Stagiaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $villeIds = Ville::pluck('id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | 1. Admin
        |--------------------------------------------------------------------------
        */

        User::create([
            'nom_complet' => 'Admin System',
            'email' => 'admin@internhub.ma',
            'password' => Hash::make('admin123'),
            'telephone' => '+212600000001',
            'etat' => 'active',
            'role' => 'Admin',
            'ville_id' => $villeIds[array_rand($villeIds)],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Entreprises - 10 users
        |--------------------------------------------------------------------------
        */

        $entreprises = [
            ['Tech Maroc', 'Informatique'],
            ['Atlas Solutions', 'Technologie'],
            ['Maroc Digital', 'Digital'],
            ['Fès Software', 'Développement logiciel'],
            ['Casablanca Tech', 'Informatique'],
            ['Rabat Innovation', 'Innovation'],
            ['Maghreb Data', 'Data Science'],
            ['Web Maroc', 'Développement Web'],
            ['Digital Atlas', 'Marketing digital'],
            ['Morocco Cloud', 'Cloud Computing'],
        ];

        $entrepriseIds = [];

        foreach ($entreprises as $index => [$nom, $secteur]) {

            $user = User::create([
                'nom_complet' => $nom,
                'email' => 'entreprise' . ($index + 1) . '@internhub.ma',
                'password' => Hash::make('password123'),
                'telephone' => '+21260000' . str_pad($index + 2, 4, '0', STR_PAD_LEFT),
                'etat' => 'active',
                'role' => 'Entreprise',
                'ville_id' => $villeIds[array_rand($villeIds)],
            ]);

            $entreprise = Entreprise::create([
                'user_id' => $user->id,
                'secteur' => $secteur,
                'adresse' => 'Avenue Mohammed V, Maroc',
                'site_web' => 'https://example.com',
                'description' => 'Entreprise spécialisée dans le domaine ' . $secteur . '.',
            ]);

            $entrepriseIds[] = $entreprise->user_id;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Encadrants - 14 users
        |--------------------------------------------------------------------------
        */

        $postes = [
            'Développeur Senior',
            'Chef de projet',
            'Architecte logiciel',
            'Ingénieur logiciel',
            'Tech Lead',
            'Responsable IT',
        ];

        $specialites = [
            'Laravel',
            'Vue.js',
            'React',
            'Python',
            'FastAPI',
            'DevOps',
            'Data Science',
        ];

        $departements = [
            'IT',
            'Développement',
            'Data',
            'Infrastructure',
            'R&D',
        ];

        for ($i = 1; $i <= 14; $i++) {

            $user = User::create([
                'nom_complet' => 'Encadrant ' . $i,
                'email' => 'encadrant' . $i . '@internhub.ma',
                'password' => Hash::make('password123'),
                'telephone' => '+21261000' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'etat' => 'active',
                'role' => 'Encadrant',
                'ville_id' => $villeIds[array_rand($villeIds)],
            ]);

            Encadrant::create([
                'user_id' => $user->id,
                'poste' => $postes[array_rand($postes)],
                'specialite' => $specialites[array_rand($specialites)],
                'departement' => $departements[array_rand($departements)],
                'entreprise_id' => $entrepriseIds[array_rand($entrepriseIds)],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Stagiaires - 25 users
        |--------------------------------------------------------------------------
        */

        $universites = [
            'Université Sidi Mohamed Ben Abdellah',
            'Université Moulay Ismail',
            'Université Hassan II',
            'Université Mohammed V',
            'Université Ibn Zohr',
        ];

        $filieres = [
            'Informatique',
            'Développement Web',
            'Génie Logiciel',
            'Data Science',
            'Réseaux et Systèmes',
            'Cybersécurité',
        ];

        $niveaux = [
            'Bac+2',
            'Bac+3',
            'Bac+4',
            'Bac+5',
        ];

        $statuts = [
            'recherche',
            'en_attente',
            'en_cours',
            'termine',
            'annule',
        ];

        for ($i = 1; $i <= 25; $i++) {

            $user = User::create([
                'nom_complet' => 'Stagiaire ' . $i,
                'email' => 'stagiaire' . $i . '@internhub.ma',
                'password' => Hash::make('password123'),
                'telephone' => '+21262000' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'etat' => 'active',
                'role' => 'Stagiaire',
                'ville_id' => $villeIds[array_rand($villeIds)],
            ]);

            Stagiaire::create([
                'user_id' => $user->id,
                'universite' => $universites[array_rand($universites)],
                'filiere' => $filieres[array_rand($filieres)],
                'niveau' => $niveaux[array_rand($niveaux)],
                'date_naissance' => fake()
                    ->dateTimeBetween('-30 years', '-18 years')
                    ->format('Y-m-d'),
                'cv_url' => 'https://example.com/cv/stagiaire' . $i,
                'linkedin_url' => 'https://linkedin.com/in/stagiaire' . $i,
                'portfolio_url' => 'https://portfolio.example.com/stagiaire' . $i,
                'statut_stage' => $statuts[array_rand($statuts)],
            ]);
        }
    }
}