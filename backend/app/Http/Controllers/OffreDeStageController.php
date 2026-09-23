<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use App\Models\Ville;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Stagiaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OffreDeStageController extends Controller
{
    /**
     * Display a listing of internship offers.
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
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('titre', 'like', "%{$search}%");
        }

        if (
            $request->filled('location') &&
            $request->input('location') !== 'all'
        ) {
            $location = $request->input('location');

            $query->whereHas('entreprise.user.ville', function ($q) use ($location) {
                $q->where('nom', $location);
            });
        }

        if (
            $request->filled('duration') &&
            $request->input('duration') !== 'all'
        ) {
            $duration = $request->input('duration');
            switch ($duration) {
                case '1-3':
                    $query->whereRaw(
                        "CAST(SUBSTRING(duree FROM '[0-9]+') AS INTEGER) BETWEEN 1 AND 3"
                    );
                    break;

                case '3-6':
                    $query->whereRaw(
                        "CAST(SUBSTRING(duree FROM '[0-9]+') AS INTEGER) BETWEEN 3 AND 6"
                    );
                    break;

                case '6+':
                    $query->whereRaw(
                        "CAST(SUBSTRING(duree FROM '[0-9]+') AS INTEGER) > 6"
                    );
                    break;
            }
        }

        if (
            $request->filled('status') &&
            $request->input('status') !== 'all'
        ) {
            $status = $request->input('status');

            $query->where('statut', $status);
        }

        if (
            $request->filled('deadline') &&
            $request->input('deadline') !== 'all'
        ) {
            switch ($request->input('deadline')) {
                case 'available':
                    $query
                        ->where('statut', 'ouverte')
                        ->whereDate(
                            'date_limite',
                            '>=',
                            now()->toDateString()
                        );
                    break;

                case 'soon':
                    $query
                        ->where('statut', 'ouverte')
                        ->whereBetween('date_limite', [
                            now()->startOfDay(),
                            now()->addDays(7)->endOfDay(),
                        ]);
                    break;

                case 'expired':
                    $query->whereDate(
                        'date_limite',
                        '<',
                        now()->toDateString()
                    );
                    break;
            }
        }

        $offres = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $villes = Ville::query()
            ->orderBy('nom', 'asc')
            ->get(['id', 'nom']);

        return Inertia::render('Stagiaire/Offres/Index', [
            'offres' => $offres,
            'villes' => $villes,
            'filters' => [
                'search' => $request->input('search', ''),
                'location' => $request->input('location', 'all'),
                'duration' => $request->input('duration', 'all'),
                'status' => $request->input('status', 'all'),
                'deadline' => $request->input('deadline', 'all'),
            ],
        ]);
    }

    /**
     * Display detailed view of a specific internship offer.
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

        $stagiaire = Stagiaire::with([
            'competences',
        ])->where('user_id', Auth::id())->first();

        return Inertia::render('Stagiaire/Offres/Show', [
            'offre' => $offre,

            'profile' => [
                'university' => $stagiaire?->universite,
                'field' => $stagiaire?->filiere,
                'level' => $stagiaire?->niveau,

                'has_cv' => !empty($stagiaire?->cv_url),

                'cv_url' => $stagiaire?->cv_url
                    ? Storage::disk('public')->url($stagiaire->cv_url)
                    : null,
            ],
        ]);
    }
}