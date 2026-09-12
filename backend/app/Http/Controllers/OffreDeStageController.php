<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use App\Models\Ville;
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
        $query = Offredestage::with([
            'entreprise.user',
            'entreprise.user.ville',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search by title
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('titre', 'like', "%{$search}%");
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by location
        |--------------------------------------------------------------------------
        */
        if (
            $request->filled('location') &&
            $request->input('location') !== 'all'
        ) {
            $location = $request->input('location');

            $query->whereHas('entreprise.user.ville', function ($q) use ($location) {
                $q->where('nom', $location);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by duration
        |--------------------------------------------------------------------------
        */
        if (
            $request->filled('duration') &&
            $request->input('duration') !== 'all'
        ) {
            $duration = $request->input('duration');

            $query->where('duree', $duration);
        }

        /*
        |--------------------------------------------------------------------------
        | Get offers
        |--------------------------------------------------------------------------
        */
        $offres = $query
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Get all cities
        |--------------------------------------------------------------------------
        */
        $villes = Ville::query()
            ->orderBy('nom', 'asc')
            ->get(['id', 'nom']);

        /*
        |--------------------------------------------------------------------------
        | Return Inertia page
        |--------------------------------------------------------------------------
        */
        return Inertia::render('Stagiaire/Offres/Index', [
            'offres' => $offres,

            'villes' => $villes,

            'filters' => [
                'search' => $request->input('search', ''),
                'location' => $request->input('location', 'all'),
                'duration' => $request->input('duration', 'all'),
                'workType' => $request->input('workType', []),
                'skills' => $request->input('skills', ''),
            ],
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
        $offre = Offredestage::with([
            'entreprise.user',
            'entreprise.user.ville',
        ])->findOrFail($id);

        return Inertia::render('Stagiaire/Offres/Show', [
            'offre' => $offre,
        ]);
    }
}