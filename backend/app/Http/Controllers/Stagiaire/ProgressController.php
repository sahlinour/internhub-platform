<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Evaluation;
use App\Models\Stage;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProgressController extends Controller
{
    /**
     * Display the logged-in intern's internship progress.
     */
    public function index(): Response
    {
        $stagiaireId = Auth::id();
        $stage = Stage::whereHas('candidature', function ($query) use ($stagiaireId) {
            $query->where('idUtilisateur_Stagiaire', $stagiaireId);
        })
            ->with([
                'candidature.offreDeStage.entreprise.user.ville',
                'encadrant.user',
            ])
            ->latest('date_debut')
            ->first();

        if (!$stage) {
            return Inertia::render('Stagiaire/Progress/Index', [
                'stage' => null,

                'stats' => [
                    'stage_progress' => 0,
                    'tasks_total' => 0,
                    'tasks_completed' => 0,
                    'tasks_in_progress' => 0,
                    'tasks_todo' => 0,
                    'tasks_progress' => 0,
                    'documents_total' => 0,
                    'documents_pending' => 0,
                    'documents_approved' => 0,
                    'documents_rejected' => 0,
                    'evaluation' => null,
                ],
                'taskStatus' => [],
                'taskPriority' => [],
                'weeklyProgress' => [],
            ]);
        }
        $tasks = Tache::where('id_Stage', $stage->id)
            ->orderBy('date_creation', 'asc')
            ->get();

        $documents = Document::where('id_Stage', $stage->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $evaluation = Evaluation::where('id_Stage', $stage->id)
            ->latest('date_evaluation')
            ->first();

        $stageStart = $stage->date_debut->copy()->startOfDay();
        $stageEnd = $stage->date_fin->copy()->startOfDay();
        $today = now()->startOfDay();

        $totalDays = $stageStart->diffInDays($stageEnd);

        if ($today->lt($stageStart)) {
            $stageProgress = 0;
        } elseif ($today->gte($stageEnd)) {
            $stageProgress = 100;
        } elseif ($totalDays <= 0) {
            $stageProgress = 100;
        } else {
            $elapsedDays = $stageStart->diffInDays($today);

            $stageProgress = round(
                ($elapsedDays / $totalDays) * 100
            );
        }

        $stageProgress = min(100, max(0, $stageProgress));
        $tasksTotal = $tasks->count();

        $tasksCompleted = $tasks
            ->where('statut', 'terminee')
            ->count();
        $tasksInProgress = $tasks
            ->where('statut', 'en_cours')
            ->count();
        $tasksTodo = $tasks
            ->where('statut', 'a_faire')
            ->count();

        $tasksProgress = $tasksTotal > 0
            ? round(($tasksCompleted / $tasksTotal) * 100)
            : 0;

        $taskStatus = [
            [
                'label' => 'Completed',
                'value' => $tasksCompleted,
            ],
            [
                'label' => 'In Progress',
                'value' => $tasksInProgress,
            ],
            [
                'label' => 'To Do',
                'value' => $tasksTodo,
            ],
        ];

        $taskPriority = [
            [
                'label' => 'High',
                'value' => $tasks->where('priorite', 'Haute')->count(),
            ],
            [
                'label' => 'Medium',
                'value' => $tasks->where('priorite', 'Moyenne')->count(),
            ],
            [
                'label' => 'Low',
                'value' => $tasks->where('priorite', 'Basse')->count(),
            ],
        ];

        $documentsTotal = $documents->count();

        $documentsPending = $documents
            ->where('statut', 'en_attente')
            ->count();

        $documentsApproved = $documents
            ->where('statut', 'valide')
            ->count();

        $documentsRejected = $documents
            ->where('statut', 'rejete')
            ->count();

        $weeklyProgress = collect();

        $currentWeekStart = $stageStart->copy();
        $weekNumber = 1;

        while ($currentWeekStart->lte($stageEnd)) {

            $currentWeekEnd = $currentWeekStart
                ->copy()
                ->addDays(6);

            if ($currentWeekEnd->gt($stageEnd)) {
                $currentWeekEnd = $stageEnd->copy();
            }

            $weekTasks = $tasks->filter(function ($task) use (
                $currentWeekStart,
                $currentWeekEnd
            ) {
                if (!$task->date_creation) {
                    return false;
                }

                $taskDate = $task->date_creation
                    ->copy()
                    ->startOfDay();

                return $taskDate->gte($currentWeekStart)
                    && $taskDate->lte($currentWeekEnd);
            });

            $totalWeekTasks = $weekTasks->count();

            $completedWeekTasks = $weekTasks
                ->where('statut', 'terminee')
                ->count();

            $weekProgress = $totalWeekTasks > 0
                ? round(
                    ($completedWeekTasks / $totalWeekTasks) * 100
                )
                : 0;

            $weeklyProgress->push([
                'week' => $weekNumber,
                'label' => 'Week ' . $weekNumber,

                'start_date' => $currentWeekStart->toDateString(),
                'end_date' => $currentWeekEnd->toDateString(),

                'total_tasks' => $totalWeekTasks,
                'completed_tasks' => $completedWeekTasks,

                'progress' => min(
                    100,
                    max(0, $weekProgress)
                ),
            ]);

            $currentWeekStart = $currentWeekStart
                ->copy()
                ->addDays(7);

            $weekNumber++;
        }

        $stageData = [
            'id' => $stage->id,
            'sujet' => $stage->sujet,
            'date_debut' => $stage->date_debut?->toDateString(),
            'date_fin' => $stage->date_fin?->toDateString(),
            'statut' => $stage->statut,
            'encadrant' => $stage->encadrant
                ? [
                    'user_id' => $stage->encadrant->user_id,
                    'poste' => $stage->encadrant->poste,
                    'specialite' => $stage->encadrant->specialite,
                    'departement' => $stage->encadrant->departement,
                    'user' => $stage->encadrant->user
                        ? [
                            'id' => $stage->encadrant->user->id,
                            'nom_complet' => $stage->encadrant->user->nom_complet,
                            'email' => $stage->encadrant->user->email,
                            'telephone' => $stage->encadrant->user->telephone,
                        ]
                        : null,
                ]
                : null,

            'entreprise' => $stage->candidature?->offreDeStage?->entreprise
                ? [
                    'user_id' => $stage->candidature->offreDeStage->entreprise->user_id,
                    'secteur' => $stage->candidature->offreDeStage->entreprise->secteur,
                    'adresse' => $stage->candidature->offreDeStage->entreprise->adresse,
                    'site_web' => $stage->candidature->offreDeStage->entreprise->site_web,
                    'description' => $stage->candidature->offreDeStage->entreprise->description,
                    'user' => $stage->candidature->offreDeStage->entreprise->user
                        ? [
                            'id' => $stage->candidature->offreDeStage->entreprise->user->id,
                            'nom_complet' => $stage->candidature->offreDeStage->entreprise->user->nom_complet,
                            'email' => $stage->candidature->offreDeStage->entreprise->user->email,
                            'telephone' => $stage->candidature->offreDeStage->entreprise->user->telephone,
                        ]
                        : null,
                    'ville' => $stage->candidature->offreDeStage->entreprise->user?->ville
                        ? [
                            'id' => $stage->candidature->offreDeStage->entreprise->user->ville->id,
                            'nom' => $stage->candidature->offreDeStage->entreprise->user->ville->nom,
                        ]
                        : null,
                ]
                : null,

            'offre' => $stage->candidature?->offreDeStage
                ? [
                    'id' => $stage->candidature->offreDeStage->id,
                    'titre' => $stage->candidature->offreDeStage->titre,
                    'duree' => $stage->candidature->offreDeStage->duree,
                    'date_limite' => $stage->candidature->offreDeStage->date_limite,
                ]
                : null,
        ];

        return Inertia::render('Stagiaire/Progress/Index', [
            'stage' => $stageData,
            'stats' => [
                'stage_progress' => $stageProgress,
                'tasks_total' => $tasksTotal,
                'tasks_completed' => $tasksCompleted,
                'tasks_in_progress' => $tasksInProgress,
                'tasks_todo' => $tasksTodo,
                'tasks_progress' => $tasksProgress,
                'documents_total' => $documentsTotal,
                'documents_pending' => $documentsPending,
                'documents_approved' => $documentsApproved,
                'documents_rejected' => $documentsRejected,
                'evaluation' => $evaluation,
            ],
            'taskStatus' => $taskStatus,
            'taskPriority' => $taskPriority,
            'weeklyProgress' => $weeklyProgress->values(),
        ]);
    }
}