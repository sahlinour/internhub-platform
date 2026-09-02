<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class StageController extends Controller
{
    /**
     * List internships created by the logged-in Entreprise.
     */
    public function index(): Response
    {
        $entrepriseId = Auth::id();

        $stages = Stage::whereHas('candidature.offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->with([
            'candidature.stagiaire.user',
            'candidature.offreDeStage',
            'encadrant.user'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return Inertia::render('Entreprise/Stages/Index', [
            'stages' => $stages,
        ]);
    }

    /**
     * Create a new Stage from an accepted Candidature.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'sujet'                   => 'required|string|max:255',
            'date_debut'              => 'required|date',
            'date_fin'                => 'nullable|date|after_or_equal:date_debut',
            'id_Candidature'          => 'required|exists:candidatures,id',
            'idUtilisateur_Encadrant' => 'nullable|exists:encadrants,user_id',
        ]);

        $candidature = Candidature::findOrFail($request->id_Candidature);

        // Ensure candidature is accepted
        if ($candidature->statut !== 'Acceptée') {
            return back()->with('error', 'The application must be accepted before creating an internship.');
        }

        Stage::create([
            'sujet'                   => $request->sujet,
            'date_debut'              => $request->date_debut,
            'date_fin'                => $request->date_fin,
            'statut'                  => 'en_cours',
            'id_Candidature'          => $request->id_Candidature,
            'idUtilisateur_Encadrant' => $request->idUtilisateur_Encadrant,
        ]);

        return back()->with('message', 'Internship successfully created.');
    }

    /**
     * Assign or update the Encadrant assigned to the Stage.
     */
    public function assignEncadrant(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'idUtilisateur_Encadrant' => 'required|exists:encadrants,user_id',
        ]);

        $stage = Stage::findOrFail($id);
        $stage->update([
            'idUtilisateur_Encadrant' => $request->idUtilisateur_Encadrant,
        ]);

        return back()->with('message', 'Encadrant assigné au stage.');
    }

    /**
     * Remove or cancel an internship record.
     */
    public function destroy($id): RedirectResponse
    {
        $entrepriseId = Auth::id();

        // Ensure the company owns the offer linked to this stage
        $stage = Stage::whereHas('candidature.offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->findOrFail($id);

        $stage->delete();

        return back()->with('message', 'Stage deleted successfully.');
    }
}