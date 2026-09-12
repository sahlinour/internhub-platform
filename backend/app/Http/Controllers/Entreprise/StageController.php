<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Stage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StageController extends Controller
{
    /**
     * List current interns belonging to the logged-in Entreprise.
     */
    public function index(): Response
    {
        $entrepriseId = Auth::id();

        $stages = Stage::where('statut', 'en_cours')
            ->whereHas(
                'candidature.offreDeStage',
                function ($q) use ($entrepriseId) {
                    $q->where(
                        'idUtilisateur_Entreprise',
                        $entrepriseId
                    );
                }
            )
            ->with([
                'candidature.stagiaire.user',
                'candidature.offreDeStage',
                'encadrant.user',
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render(
            'Entreprise/Stages/Index',
            [
                'stages' => $stages,
            ]
        );
    }

    /**
     * Create a Stage from an accepted Candidature.
     */
    public function store(Request $request): RedirectResponse
    {
        $entrepriseId = Auth::id();

        $request->validate([
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
                'nullable',
                'date',
                'after_or_equal:date_debut',
            ],

            'id_Candidature' => [
                'required',
                'exists:candidatures,id',
            ],

            'idUtilisateur_Encadrant' => [
                'nullable',
                Rule::exists('encadrants', 'user_id')
                    ->where(function ($query) use ($entrepriseId) {
                        $query->where(
                            'entreprise_id',
                            $entrepriseId
                        );
                    }),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify candidature belongs to this company
        |--------------------------------------------------------------------------
        */

        $candidature = Candidature::whereHas(
            'offreDeStage',
            function ($q) use ($entrepriseId) {
                $q->where(
                    'idUtilisateur_Entreprise',
                    $entrepriseId
                );
            }
        )
            ->findOrFail(
                $request->id_Candidature
            );

        /*
        |--------------------------------------------------------------------------
        | Candidature must be accepted
        |--------------------------------------------------------------------------
        */

        if ($candidature->statut !== 'acceptee') {
            return back()->with(
                'error',
                'The application must be accepted before creating an internship.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Avoid creating another Stage for the same candidature
        |--------------------------------------------------------------------------
        */

        if ($candidature->stage) {
            return back()->with(
                'error',
                'An internship has already been created for this application.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create internship
        |--------------------------------------------------------------------------
        */

        Stage::create([
            'sujet' => $request->sujet,

            'date_debut' => $request->date_debut,

            'date_fin' => $request->date_fin,

            'statut' => 'en_cours',

            'id_Candidature' =>
                $candidature->id,

            'idUtilisateur_Encadrant' =>
                $request->idUtilisateur_Encadrant,
        ]);

        return back()->with(
            'message',
            'Internship successfully created.'
        );
    }

    /**
     * Assign or change the company supervisor.
     */
    public function assignEncadrant(
        Request $request,
        $id
    ): RedirectResponse {
        $entrepriseId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Supervisor must belong to this company
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'idUtilisateur_Encadrant' => [
                'required',

                Rule::exists(
                    'encadrants',
                    'user_id'
                )->where(
                    function ($query) use ($entrepriseId) {
                        $query->where(
                            'entreprise_id',
                            $entrepriseId
                        );
                    }
                ),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Stage must belong to this company
        |--------------------------------------------------------------------------
        */

        $stage = Stage::whereHas(
            'candidature.offreDeStage',
            function ($q) use ($entrepriseId) {
                $q->where(
                    'idUtilisateur_Entreprise',
                    $entrepriseId
                );
            }
        )
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Assign supervisor
        |--------------------------------------------------------------------------
        */

        $stage->update([
            'idUtilisateur_Encadrant' =>
                $request->idUtilisateur_Encadrant,
        ]);

        return back()->with(
            'message',
            'Supervisor assigned successfully.'
        );
    }

    /**
     * Delete an internship.
     */
    public function destroy($id): RedirectResponse
    {
        $entrepriseId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Only delete stages belonging to this company
        |--------------------------------------------------------------------------
        */

        $stage = Stage::whereHas(
            'candidature.offreDeStage',
            function ($q) use ($entrepriseId) {
                $q->where(
                    'idUtilisateur_Entreprise',
                    $entrepriseId
                );
            }
        )
            ->findOrFail($id);

        $stage->delete();

        return back()->with(
            'message',
            'Internship deleted successfully.'
        );
    }
}
