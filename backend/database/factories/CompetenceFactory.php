<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompetenceFactory extends Factory
{
    public function definition(): array
    {
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Node.js', 
            'Python', 'Django', 'Docker', 'PostgreSQL', 'MySQL', 'Git', 
            'Tailwind CSS', 'Bootstrap', 'REST API', 'GraphQL', 'TypeScript', 
            'Java', 'Spring Boot', 'Figma', 'Linux', 'DevOps', 'CI/CD'
        ];

        return [
            'nom_competence' => fake()->unique()->randomElement($skills),
        ];
    }
}