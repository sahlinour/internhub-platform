<?php

namespace App\Services;

use App\Models\Competence;
use App\Models\Stagiaire;
use App\Models\Offredestage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiMatchingService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.fastapi.url', 'http://fastapi:8001');
    }

    public function getMatchScore(Stagiaire $stagiaire, Offredestage $offre): array
    {
        $stagiaire->load('competences');

        $competences = $stagiaire->competences->map(function ($c) {
            return [
                'nom_competence' => $c->nom_competence,
                'niveau' => $c->pivot->niveau ?? 'Debutant',
                'experience' => (string)($c->pivot->experience ?? '0'),
            ];
        })->toArray();

        $payload = [
            'stagiaire' => [
                'user_id' => (int) $stagiaire->user_id,
                'universite' => $stagiaire->universite,
                'filiere' => $stagiaire->filiere,
                'niveau' => $stagiaire->niveau,
                'cv_text' => $stagiaire->cv_text ?? '',
                'competences' => $competences,
            ],
            'offre' => [
                'id' => (int) $offre->id,
                'titre' => $offre->titre,
                'description' => $offre->description,
                'required_skills' => $offre->required_skills ?? [],
            ],
        ];

        try {
            $response = Http::timeout(30)->post("{$this->baseUrl}/api/match", $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('FastAPI Match Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('FastAPI Match Connection Exception: ' . $e->getMessage());
        }

        return [
            'match_percentage' => 0,
            'matching_skills' => [],
            'missing_skills' => [],
            'vector_similarity_score' => 0.0,
            'reasoning' => 'Error connecting to matching service.',
        ];
    }

    public function parseCvPdf(string $pdfPath, ?string $originalName = null): array
    {
        if (!file_exists($pdfPath)) {
            Log::error("FastAPI Parse CV Error: File not found at {$pdfPath}");
            return ['error' => 'File not found on server'];
        }

        $knownSkills = Competence::pluck('nom_competence')->toArray();

        $filename = $originalName ?? basename($pdfPath);
        if (!str_ends_with(strtolower($filename), '.pdf')) {
            $filename .= '.pdf';
        }

        $fileStream = fopen($pdfPath, 'r');

        try {
            $response = Http::timeout(30)
                ->attach(
                    'file', 
                    $fileStream, 
                    $filename,
                    ['Content-Type' => 'application/pdf']
                )
                ->post("{$this->baseUrl}/api/parse-cv", [
                    'known_skills' => json_encode($knownSkills),
                ]);

            if (is_resource($fileStream)) {
                fclose($fileStream);
            }

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('FastAPI Parse CV Response Error: Status ' . $response->status() . ' - ' . $response->body());
            return $response->json() ?? ['error' => 'Failed to parse PDF'];

        } catch (\Exception $e) {
            if (is_resource($fileStream)) {
                fclose($fileStream);
            }

            Log::error('FastAPI Parse CV Connection Exception: ' . $e->getMessage());
            return ['error' => 'Service connection failed: ' . $e->getMessage()];
        }
    }
}