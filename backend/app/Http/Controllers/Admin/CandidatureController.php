<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CandidatureController extends Controller
{
    /**
     * Display a list of offers with their candidatures count for Admin.
     */
    public function index(Request $request): Response
    {
        $query = Offredestage::with(['entreprise.user'])
            ->withCount('candidatures'); // Adds candidatures_count attribute to each offer

        // Filter by title or company name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhereHas('entreprise.user', function ($u) use ($search) {
                      $u->where('nom_complet', 'like', "%{$search}%");
                  });
            });
        }

        $offres = $query->orderBy('created_at', 'desc')
                        ->paginate(12)
                        ->withQueryString();

        return Inertia::render('Admin/Candidatures/Index', [
            'offres'  => $offres,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Display all candidatures submitted for a specific offer.
     */
    public function showByOffer($offreId): Response
    {
        $offre = Offredestage::with(['entreprise.user'])->findOrFail($offreId);

        $candidatures = Candidature::where('id_Offre_De_Stage', $offreId)
            ->with(['stagiaire.user', 'stagiaire.competences'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Admin/Candidatures/ShowOfferCandidatures', [
            'offre'        => $offre,
            'candidatures' => $candidatures,
        ]);
    }
}