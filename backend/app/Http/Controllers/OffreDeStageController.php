<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OffreDeStageController extends Controller
{
    /**
     * Display a listing of active internship offers for public guests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // Query only 'active' offers with company profile and user info
        $query = Offredestage::with(['entreprise.user', 'entreprise.user.ville']);

        // Search by offer title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('titre', 'like', "%{$search}%");
        }

        // Filter by duration if provided
        if ($request->filled('duree')) {
            $query->where('duree', $request->duree);
        }

        // Paginate active offers
        $offres = $query->orderBy('created_at', 'desc')
                        ->paginate(12)
                        ->withQueryString();

        return Inertia::render('Villes/Index', [
            'offres'  => $offres,
            'filters' => $request->only(['search', 'duree']),
        ]);
    }

    /**
     * Display detailed view of a specific internship offer for guests.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id): Response
    {
        // Load single active offer with full enterprise details
        $offre = Offredestage::where('statut', 'active')
            ->with(['entreprise.user', 'entreprise.user.ville'])
            ->findOrFail($id);

        return Inertia::render('Guest/Offres/Show', [
            'offre' => $offre,
        ]);
    }
}