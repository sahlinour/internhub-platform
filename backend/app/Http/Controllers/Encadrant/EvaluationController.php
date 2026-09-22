<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EvaluationController extends Controller
{
    /**
     * Display evaluations and, when stage_id is provided,
     * the selected intern to evaluate.
     */
    public function index(Request $request): Response
    {
        $encadrantId = Auth::id();

        $evaluations = Evaluation::where(
            'idUtilisateur_Encadrant',
            $encadrantId
        )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
            ])
            ->orderByDesc('date_evaluation')
            ->paginate(10);

        $selectedStage = null;

        if ($request->filled('stage_id')) {

            $stage = Stage::where(
                'idUtilisateur_Encadrant',
                $encadrantId
            )
                ->with([
                    'candidature.stagiaire.user',
                    'candidature.offreDeStage',
                    'taches',
                ])
                ->findOrFail($request->stage_id);

            $totalTasks = $stage->taches->count();

            $completedTasks = $stage->taches
                ->where('statut', 'terminee')
                ->count();

            $progress = $totalTasks > 0
                ? round(($completedTasks / $totalTasks) * 100)
                : 0;

            $selectedStage = [
                'id' => $stage->id,

                'sujet' => $stage->sujet,

                'intern' => $stage
                    ->candidature
                    ?->stagiaire
                    ?->user,

                'offer' => $stage
                    ->candidature
                    ?->offreDeStage,

                'total_tasks' => $totalTasks,

                'completed_tasks' => $completedTasks,

                'progress' => $progress,
            ];
        }

        return Inertia::render(
            'Encadrant/Evaluations/Index',
            [
                'evaluations' => $evaluations,
                'selectedStage' => $selectedStage,
            ]
        );
    }

    /**
     * Store a new evaluation.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_Stage' => [
                'required',
                'exists:stages,id',
            ],

            'type_evaluation' => [
                'required',
                'string',
                'max:255',
            ],

            'note_technique' => [
                'required',
                'numeric',
                'min:0',
                'max:20',
            ],

            'note_relationnelle' => [
                'required',
                'numeric',
                'min:0',
                'max:20',
            ],

            'remarque_encadrant' => [
                'nullable',
                'string',
            ],
        ]);

        $encadrantId = Auth::id();

        // Make sure this stage belongs to the logged-in supervisor.
        $stage = Stage::where(
            'idUtilisateur_Encadrant',
            $encadrantId
        )
            ->with('taches')
            ->findOrFail($validated['id_Stage']);

        /*
         * Backend security:
         * evaluation is allowed only when all tasks are completed.
         */
        $totalTasks = $stage->taches->count();

        $completedTasks = $stage->taches
            ->where('statut', 'terminee')
            ->count();

        if (
            $totalTasks === 0 ||
            $completedTasks !== $totalTasks
        ) {
            throw ValidationException::withMessages([
                'id_Stage' =>
                    'The intern must complete 100% of the tasks before evaluation.',
            ]);
        }

        // Calculate global score.
        $noteGlobal = (
            $validated['note_technique']
            + $validated['note_relationnelle']
        ) / 2;

        Evaluation::create([
            'type_evaluation' =>
                $validated['type_evaluation'],

            'note_technique' =>
                $validated['note_technique'],

            'note_relationnelle' =>
                $validated['note_relationnelle'],

            'note_global' =>
                $noteGlobal,

            'remarque_encadrant' =>
                $validated['remarque_encadrant'] ?? null,

            'date_evaluation' =>
                now(),

            'idUtilisateur_Encadrant' =>
                $encadrantId,

            'id_Stage' =>
                $stage->id,
        ]);

        return redirect()
            ->route('encadrant.evaluations.index')
            ->with(
                'message',
                'Évaluation enregistrée avec succès.'
            );
    }

    /**
     * Update an evaluation.
     */
    public function update(
        Request $request,
        $id
    ): RedirectResponse {

        $encadrantId = Auth::id();

        $evaluation = Evaluation::where(
            'idUtilisateur_Encadrant',
            $encadrantId
        )->findOrFail($id);

        $validated = $request->validate([
            'type_evaluation' => [
                'required',
                'string',
                'max:255',
            ],

            'note_technique' => [
                'required',
                'numeric',
                'min:0',
                'max:20',
            ],

            'note_relationnelle' => [
                'required',
                'numeric',
                'min:0',
                'max:20',
            ],

            'remarque_encadrant' => [
                'nullable',
                'string',
            ],
        ]);

        $noteGlobal = (
            $validated['note_technique']
            + $validated['note_relationnelle']
        ) / 2;

        $evaluation->update([
            'type_evaluation' =>
                $validated['type_evaluation'],

            'note_technique' =>
                $validated['note_technique'],

            'note_relationnelle' =>
                $validated['note_relationnelle'],

            'note_global' =>
                $noteGlobal,

            'remarque_encadrant' =>
                $validated['remarque_encadrant'] ?? null,
        ]);

        return back()->with(
            'message',
            'Évaluation mise à jour.'
        );
    }
}
