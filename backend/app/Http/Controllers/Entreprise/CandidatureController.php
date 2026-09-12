<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Offredestage;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CandidatureController extends Controller
{
    /**
     * List all applications received for the company's offers.
     */
    public function index(Request $request): Response
    {
        $entrepriseId = Auth::id();
        $offres = Offredestage::where(
            'idUtilisateur_Entreprise',
            $entrepriseId
        )
            ->select('id', 'titre')
            ->orderBy('created_at', 'desc')
            ->get();
        $query = Candidature::whereHas(
            'offreDeStage',
            function ($q) use ($entrepriseId) {
                $q->where(
                    'idUtilisateur_Entreprise',
                    $entrepriseId
                );
            }
        )->with([
            'stagiaire.user',
            'stagiaire.competences',
            'offreDeStage',
        ]);


        if ($request->filled('statut')) {
            $query->where(
                'statut',
                $request->statut
            );
        }

        if ($request->filled('offre_id')) {
            $query->where(
                'id_Offre_De_Stage',
                $request->offre_id
            );
        }

        $candidatures = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render(
            'Entreprise/Candidatures/Index',
            [
                'candidatures' => $candidatures,

                'offres' => $offres,

                'filters' => $request->only([
                    'statut',
                    'offre_id',
                ]),
            ]
        );
    }

public function showAccepted($id): Response
        {
            $entrepriseId = Auth::id();

            $candidature = Candidature::where('statut', 'acceptee')
                ->whereHas('offreDeStage', function ($q) use ($entrepriseId) {
                    $q->where('idUtilisateur_Entreprise', $entrepriseId);
                })
                ->with([
                    'stagiaire.user',
                    'stagiaire.competences',
                    'offreDeStage',
                    'stage.encadrant.user',
                ])
                ->findOrFail($id);

            $encadrants = \App\Models\Encadrant::where(
                'entreprise_id',
                $entrepriseId
            )
                ->with('user')
                ->get();

            return Inertia::render('Entreprise/AcceptedStudents/Show', [
                'candidature' => $candidature,
                'encadrants' => $encadrants,
            ]);
        }

            /**
         * List accepted students for the logged-in Entreprise.
         */
public function accepted(Request $request): Response
{
    $entrepriseId = Auth::id();

    $query = Candidature::where('statut', 'acceptee')
        ->whereHas(
            'offreDeStage',
            function ($q) use ($entrepriseId) {
                $q->where(
                    'idUtilisateur_Entreprise',
                    $entrepriseId
                );
            }
        )
        ->with([
            'stagiaire.user',
            'offreDeStage',
            'stage',
        ]);

    if ($request->filled('offre_id')) {
        $query->where(
            'id_Offre_De_Stage',
            $request->offre_id
        );
    }

    $acceptedStudents = $query
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();

    return Inertia::render(
        'Entreprise/AcceptedStudents/Index',
        [
            'acceptedStudents' => $acceptedStudents,
        ]
    );
}
public function show($id): Response
{
    $entrepriseId = Auth::id();

    $candidature = Candidature::whereHas(
        'offreDeStage',
        function ($query) use ($entrepriseId) {
            $query->where(
                'idUtilisateur_Entreprise',
                $entrepriseId
            );
        }
    )
        ->with([
            'stagiaire.user.ville',
            'stagiaire.competences',
            'offreDeStage',
            'stage.encadrant.user',
        ])
        ->findOrFail($id);

    return Inertia::render(
        'Entreprise/Candidatures/Show',
        [
            'candidature' => $candidature,
        ]
    );
}

public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        $entrepriseId = Auth::id();

        $candidature = Candidature::whereHas('offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->findOrFail($id);

        $candidature->update([
            'statut' => $request->statut,
        ]);

        return back()->with('message', 'Application status updated.');
    }
}
