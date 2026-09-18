<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\Offredestage;
use App\Services\AiMatchingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AiMatchingController extends Controller
{
    protected AiMatchingService $aiMatchingService;

    public function __construct(AiMatchingService $aiMatchingService)
    {
        $this->aiMatchingService = $aiMatchingService;
    }

    /**
     * Parse uploaded PDF CV.
     * Endpoint: POST /api/parse-cv
     */
    public function parseCv(Request $request): JsonResponse
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $file = $request->file('cv');
        $result = $this->aiMatchingService->parseCvPdf($file->getRealPath());

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }

        return response()->json($result, 200);
    }

    /**
     * Calculate match score between a Stagiaire and an Offre.
     * Endpoint: POST /api/match-score
     */
    public function calculateMatch(Request $request): JsonResponse
    {
        $request->validate([
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'offre_id' => 'required|exists:offredestages,id',
        ]);

        $stagiaire = Stagiaire::findOrFail($request->stagiaire_id);
        $offre = Offredestage::findOrFail($request->offre_id);

        $result = $this->aiMatchingService->getMatchScore($stagiaire, $offre);

        return response()->json($result, 200);
    }
}