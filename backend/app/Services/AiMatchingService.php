<?php

namespace App\Services;

use App\Models\Competence;
use App\Models\Offredestage;
use App\Models\Stagiaire;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class AiMatchingService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config(
                'services.fastapi.url',
                'http://fastapi:8001'
            ),
            '/'
        );
    }


    /**
     * Match existing stagiaire with one offer.
     */
    public function getMatchScore(
        Stagiaire $stagiaire,
        Offredestage $offre
    ): array {

        $stagiaire->load(
            'competences'
        );

        $competences = $stagiaire
            ->competences
            ->map(function ($competence) {

                return [
                    'nom_competence' =>
                        $competence->nom_competence,

                    'niveau' =>
                        $competence->pivot->niveau
                        ?? 'Debutant',

                    'experience' =>
                        $competence->pivot->experience
                        ?? '0',
                ];
            })
            ->values()
            ->toArray();


        $requiredSkills =
            $offre->required_skills ?? [];


        $payload = [

            'stagiaire' => [

                'user_id' =>
                    (int) $stagiaire->user_id,

                'universite' =>
                    $stagiaire->universite,

                'filiere' =>
                    $stagiaire->filiere,

                'niveau' =>
                    $stagiaire->niveau,

                'cv_text' =>
                    $stagiaire->cv_text ?? '',

                'competences' =>
                    $competences,
            ],

            'offre' => [

                'id' =>
                    (int) $offre->id,

                'titre' =>
                    $offre->titre,

                'description' =>
                    $offre->description,

                'required_skills' =>
                    $requiredSkills,

            ],
        ];


        $response = Http::timeout(60)
            ->post(
                $this->baseUrl . '/api/match',
                $payload
            );


        if ($response->successful()) {

            return $response->json();
        }


        return [

            'match_percentage' => 0,

            'matching_skills' => [],

            'missing_skills' => $requiredSkills,

            'vector_similarity_score' => 0,

            'reasoning' =>
                'Matching service unavailable.',
        ];
    }


    /**
     * Parse PDF CV with FastAPI.
     */
    public function parseCvPdf(
        string $pdfPath,
        ?string $originalName = null
    ): array {

        if (!file_exists($pdfPath)) {

            throw new \RuntimeException(
                'CV file not found.'
            );
        }


        $skills = Competence::pluck(
            'nom_competence'
        )
        ->filter()
        ->values()
        ->toArray();


        $response = Http::timeout(90)
            ->attach(
                'file',
                file_get_contents($pdfPath),
                $originalName ?? 'cv.pdf'
            )
            ->post(
                $this->baseUrl . '/api/parse-cv',
                [
                    'known_skills' =>
                        json_encode($skills),
                ]
            );


        if (!$response->successful()) {

            throw new \RuntimeException(
                'FastAPI CV parser error: '
                . $response->body()
            );
        }


        return $response->json();
    }


    /**
     * Upload CV and match against all offers.
     */
    public function matchCvAgainstAllOffers(UploadedFile $file): array
{
    // 1. Parse CV
    $parsed = $this->parseCvPdf(
        $file->getRealPath(),
        $file->getClientOriginalName()
    );

    $cvText = $parsed['extracted_text'] ?? '';

    /*
     * The CV parser may return:
     * - detected_skills
     * - matched_db_skills
     */
    $detectedSkills =
        $parsed['detected_skills']
        ?? $parsed['matched_db_skills']
        ?? [];

    // Normalize skills
    $competencesPayload = collect($detectedSkills)
        ->map(function ($skill) {

            $name = is_array($skill)
                ? ($skill['nom_competence'] ?? '')
                : $skill;

            return [
                'nom_competence' => trim((string) $name),
                'niveau' => 'Debutant',
                'experience' => '0',
            ];
        })
        ->filter(function ($item) {
            return !empty($item['nom_competence']);
        })
        ->values()
        ->toArray();

    /*
     * Candidate sent to FastAPI
     */
    $stagiairePayload = [
        'user_id' => 0,
        'universite' => null,
        'filiere' => null,
        'niveau' => null,
        'cv_text' => $cvText,
        'competences' => $competencesPayload,
    ];

    /*
     * ALL skills existing in database.
     * FastAPI uses these to detect skills inside offers.
     */
    $knownSkills = Competence::query()
        ->pluck('nom_competence')
        ->filter()
        ->map(fn ($skill) => trim($skill))
        ->filter()
        ->unique()
        ->values()
        ->toArray();

    /*
     * Get internship offers from offredestages.
     */
    $offers = Offredestage::with('entreprise')->get();

    $results = [];

    foreach ($offers as $offer) {

        /*
         * required_skills can be:
         * - array
         * - JSON string
         * - null
         */
        $requiredSkills = $offer->required_skills ?? [];

        if (is_string($requiredSkills)) {
            $decoded = json_decode($requiredSkills, true);

            $requiredSkills = is_array($decoded)
                ? $decoded
                : [];
        }

        if (!is_array($requiredSkills)) {
            $requiredSkills = [];
        }

        /*
         * Payload sent to FastAPI.
         */
        $payload = [
            'stagiaire' => $stagiairePayload,

            'offre' => [
                'id' => (int) $offer->id,

                'titre' => (string) (
                    $offer->titre ?? ''
                ),

                'description' => (string) (
                    $offer->description ?? ''
                ),

                'required_skills' => array_values(
                    $requiredSkills
                ),

                'known_skills' => $knownSkills,
            ],
        ];

        try {

            $response = Http::timeout(60)
                ->acceptJson()
                ->post(
                    $this->baseUrl . '/api/match',
                    $payload
                );

            /*
             * If FastAPI rejects the offer,
             * log it instead of silently hiding it.
             */
            if (!$response->successful()) {

                \Log::error(
                    "FastAPI matching failed",
                    [
                        'offer_id' => $offer->id,
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]
                );

                continue;
            }

            $match = $response->json();

            /*
             * Company name
             */
            $company = 'Entreprise';

            if ($offer->entreprise) {
                $company =
                    $offer->entreprise->nom_entreprise
                    ?? $offer->entreprise->nom
                    ?? $offer->entreprise->name
                    ?? 'Entreprise';
            }

            /*
             * IMPORTANT:
             * Don't call a possibly non-existent
             * offres.show route inside the matching logic.
             */
            $offerUrl = '#';

            /*
             * If your route exists, you can enable this later:
             *
             * $offerUrl = route('offres.show', $offer->id);
             */

            $results[] = [
                'id' => (int) $offer->id,

                'title' => $offer->titre
                    ?? 'Offre de Stage',

                'company' => $company,

                'location' =>
                    $offer->ville
                    ?? $offer->location
                    ?? 'Non spécifiée',

                'type' =>
                    $offer->type
                    ?? 'Stage',

                'score' =>
                    (int) (
                        $match['match_percentage']
                        ?? 0
                    ),

                'matched' =>
                    $match['matching_skills']
                    ?? [],

                'missing' =>
                    $match['missing_skills']
                    ?? [],

                'reasoning' =>
                    $match['reasoning']
                    ?? '',

                'url' => $offerUrl,
            ];

        } catch (\Throwable $e) {

            /*
             * NEVER silently hide the error.
             */
            \Log::error(
                "CV matching exception",
                [
                    'offer_id' => $offer->id,
                    'offer_title' => $offer->titre,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            continue;
        }
    }

    /*
     * Highest score first.
     */
    usort(
        $results,
        fn ($a, $b) =>
            $b['score'] <=> $a['score']
    );

    return [
        'skills' => array_column(
            $competencesPayload,
            'nom_competence'
        ),

        'offers' => $results,
    ];
}
}