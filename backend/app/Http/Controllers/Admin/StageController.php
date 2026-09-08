<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use App\Models\Candidature;
use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StageController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Stage::with([
            'candidature.stagiaire.user',
            'candidature.offreDeStage.entreprise.user',
            'encadrant.user',
        ]);

        if ($request->filled('statut')) {
            $query->where(
                'statut',
                $request->statut
            );
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'sujet',
                    'like',
                    "%{$search}%"
                )
                    ->orWhereHas(
                        'candidature.stagiaire.user',
                        function ($sq) use ($search) {
                            $sq->where(
                                'nom_complet',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
            });
        }

        $stages = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render(
            'Admin/Stages/Index',
            [
                'stages' => $stages,
                'filters' => $request->only([
                    'statut',
                    'search',
                ]),
            ]
        );
    }

    public function create(): Response
    {
        $candidatures = Candidature::with([
            'stagiaire.user',
            'offreDeStage.entreprise.user',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        $encadrants = Encadrant::with('user')
            ->get();

        return Inertia::render(
            'Admin/Stages/Create',
            [
                'candidatures' => $candidatures,
                'encadrants' => $encadrants,
            ]
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'sujet' => [
                'required',
                'string',
                'max:255',
            ],

            'date_debut' => [
                'required',
                'date',
            ],

            'date_fin' => [
                'required',
                'date',
                'after_or_equal:date_debut',
            ],

            'statut' => [
                'required',
                'in:En cours,Terminée,Annulée',
            ],

            'idUtilisateur_Encadrant' => [
                'required',
                'exists:encadrants,user_id',
            ],

            'id_Candidature' => [
                'required',
                'exists:candidatures,id',
            ],
        ]);

        Stage::create($validated);

        return redirect()
            ->route('admin.stages.index')
            ->with(
                'message',
                'Internship created successfully.'
            );
    }

    public function show($id): Response
    {
        $stage = Stage::with([
            'candidature.stagiaire.user',
            'candidature.offreDeStage.entreprise.user',
            'encadrant.user',
        ])->findOrFail($id);

        return Inertia::render(
            'Admin/Stages/Show',
            [
                'stage' => $stage,
            ]
        );
    }

    public function edit($id): Response
    {
        $stage = Stage::with([
            'candidature.stagiaire.user',
            'candidature.offreDeStage.entreprise.user',
            'encadrant.user',
        ])->findOrFail($id);

        $candidatures = Candidature::with([
            'stagiaire.user',
            'offreDeStage.entreprise.user',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        $encadrants = Encadrant::with('user')
            ->get();

        return Inertia::render(
            'Admin/Stages/Edit',
            [
                'stage' => $stage,
                'candidatures' => $candidatures,
                'encadrants' => $encadrants,
            ]
        );
    }

    public function update(
        Request $request,
        $id
    ): RedirectResponse {
        $validated = $request->validate([
            'sujet' => [
                'required',
                'string',
                'max:255',
            ],

            'date_debut' => [
                'required',
                'date',
            ],

            'date_fin' => [
                'required',
                'date',
                'after_or_equal:date_debut',
            ],

            'statut' => [
                'required',
                'in:En cours,Terminée,Annulée',
            ],

            'idUtilisateur_Encadrant' => [
                'required',
                'exists:encadrants,user_id',
            ],

            'id_Candidature' => [
                'required',
                'exists:candidatures,id',
            ],
        ]);

        $stage = Stage::findOrFail($id);

        $stage->update($validated);

        return redirect()
            ->route(
                'admin.stages.show',
                $stage->id
            )
            ->with(
                'message',
                'Internship updated successfully.'
            );
    }

    public function updateStatus(
        Request $request,
        $id
    ): RedirectResponse {
        $validated = $request->validate([
            'statut' => [
                'required',
                'in:En cours,Terminée,Annulée',
            ],
        ]);

        $stage = Stage::findOrFail($id);

        $stage->update([
            'statut' => $validated['statut'],
        ]);

        return back()->with(
            'message',
            'Internship status updated successfully.'
        );
    }

    public function destroy($id): RedirectResponse
    {
        $stage = Stage::findOrFail($id);

        $stage->delete();

        return redirect()
            ->route('admin.stages.index')
            ->with(
                'message',
                'Internship deleted successfully.'
            );
    }
}
