<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use App\Models\Stagiaire;
use App\Services\AiMatchingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AiMatchingController extends Controller
{
    public function __construct(
        private AiMatchingService $aiMatchingService
    ) {
    }

    /**
     * Parse CV only.
     */
    public function parseCv(
        Request $request
    ): JsonResponse {

        $request->validate([
            'cv' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ]);

        $result = $this->aiMatchingService
            ->parseCvPdf(
                $request->file('cv')->getRealPath(),
                $request->file('cv')->getClientOriginalName()
            );

        return response()->json(
            $result
        );
    }


    /**
     * Match a stagiaire with one offer.
     */
    public function calculateMatch(
        Request $request
    ): JsonResponse {

        $validated = $request->validate([
            'stagiaire_id' => [
                'required',
                'exists:stagiaires,user_id',
            ],

            'offre_id' => [
                'required',
                'exists:offredestages,id',
            ],
        ]);

        $stagiaire = Stagiaire::where(
            'user_id',
            $validated['stagiaire_id']
        )->firstOrFail();

        $offre = Offredestage::findOrFail(
            $validated['offre_id']
        );

        $result = $this->aiMatchingService
            ->getMatchScore(
                $stagiaire,
                $offre
            );

        return response()->json(
            $result
        );
    }


    /**
     * Upload CV and match it against
     * all internship offers.
     */
    public function matchCv(
        Request $request
    ): JsonResponse {

        $request->validate([
            'cv' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ]);

        $result = $this->aiMatchingService
            ->matchCvAgainstAllOffers(
                $request->file('cv')
            );

        return response()->json(
            $result
        );
    }
}