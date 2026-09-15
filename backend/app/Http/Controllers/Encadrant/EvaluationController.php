<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
// use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EvaluationController extends Controller
{
    /**
     * Display evaluations submitted by the logged-in supervisor.
     */
    public function index(): Response
    {
        $encadrantId = Auth::id();

        $evaluations = Evaluation::where('idUtilisateur_Encadrant', $encadrantId)
            ->with(['stage.candidature.stagiaire.user', 'stage.candidature.offreDeStage'])
            ->orderBy('date_evaluation', 'desc')
            ->paginate(10);

        return Inertia::render('Encadrant/Evaluations/Index', [
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Store a new evaluation for a stage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_Stage'           => 'required|exists:stages,id',
            'type_evaluation'    => 'required|string|max:255', // e.g., 'mi-parcours', 'finale'
            'note_technique'     => 'required|numeric|min:0|max:20',
            'note_relationnelle' => 'required|numeric|min:0|max:20',
            'remarque_encadrant' => 'nullable|string',
        ]);

        $encadrantId = Auth::id();

        // Calculate global score automatically (average of technical and relational)
        $noteGlobal = ($request->note_technique + $request->note_relationnelle) / 2;

        Evaluation::create([
            'type_evaluation'         => $request->type_evaluation,
            'note_technique'          => $request->note_technique,
            'note_relationnelle'      => $request->note_relationnelle,
            'note_global'             => $noteGlobal,
            'remarque_encadrant'      => $request->remarque_encadrant,
            'date_evaluation'         => now(),
            'idUtilisateur_Encadrant' => $encadrantId,
            'id_Stage'                => $request->id_Stage,
        ]);

        return back()->with('message', 'Évaluation enregistrée avec succès.');
    }

    /**
     * Update an evaluation.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $encadrantId = Auth::id();

        $evaluation = Evaluation::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);

        $request->validate([
            'type_evaluation'    => 'required|string|max:255',
            'note_technique'     => 'required|numeric|min:0|max:20',
            'note_relationnelle' => 'required|numeric|min:0|max:20',
            'remarque_encadrant' => 'nullable|string',
        ]);

        $noteGlobal = ($request->note_technique + $request->note_relationnelle) / 2;

        $evaluation->update([
            'type_evaluation'    => $request->type_evaluation,
            'note_technique'     => $request->note_technique,
            'note_relationnelle' => $request->note_relationnelle,
            'note_global'        => $noteGlobal,
            'remarque_encadrant' => $request->remarque_encadrant,
        ]);

        return back()->with('message', 'Évaluation mise à jour.');
    }
}