<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use App\Models\Reunion;
use App\Models\Activite;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        /*
         * On suppose que :
         *
         * User possède une relation encadrant()
         * Encadrant possède une relation stagiaires()
         * Stagiaire possède une relation taches()
         */
        $encadrant = $user->encadrant;

        abort_if(
            !$encadrant,
            403,
            'Aucun profil encadrant associé à cet utilisateur.'
        );

        $stagiairesModels = $encadrant->stagiaires()
            ->with([
                'user:id,nom_complet',
                'taches:id,stagiaire_id,statut',
            ])
            ->get();

        /*
         * Transformation des stagiaires dans le format attendu
         * par StagiaireCard.vue.
         */
        $stagiaires = $stagiairesModels->map(function ($stagiaire) {
            $totalTasks = $stagiaire->taches->count();

            $completedTasks = $stagiaire->taches
                ->where('statut', 'terminee')
                ->count();

            $progress = $totalTasks > 0
                ? (int) round(($completedTasks / $totalTasks) * 100)
                : 0;

            return [
                'id' => $stagiaire->user_id,
                'name' => $stagiaire->user?->nom_complet
                    ?? 'Stagiaire',
                'filiere' => $stagiaire->filiere
                    ?? 'Filière non renseignée',
                'progress' => $progress,
                'completedTasks' => $completedTasks,
                'totalTasks' => $totalTasks,
                'status' => $progress < 50
                    ? 'at_risk'
                    : 'on_track',
                'lastActivity' => $stagiaire->updated_at
                    ? $stagiaire->updated_at->diffForHumans()
                    : 'Aucune activité',
            ];
        })->values();

        $stagiaireIds = $stagiairesModels
            ->pluck('user_id')
            ->filter();

        /*
         * Tâches soumises par les stagiaires et attendant
         * la validation de l'encadrant.
         */
        $pendingTasksQuery = Tache::query()
            ->with('stagiaire.user')
            ->whereIn('stagiaire_id', $stagiaireIds)
            ->where('statut', 'soumise');

        $pendingReviews = (clone $pendingTasksQuery)->count();

        $pendingTasks = $pendingTasksQuery
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->titre,
                    'stagiaire' =>
                        $task->stagiaire?->user?->nom_complet
                        ?? 'Stagiaire',
                    'date' => $task->updated_at
                        ->translatedFormat('d F Y'),
                    'priority' => $task->priorite ?? 'medium',
                ];
            })
            ->values();

        /*
         * Réunions futures de l'encadrant.
         */
        $meetings = Reunion::query()
            ->where('encadrant_id', $encadrant->user_id)
            ->where('date_reunion', '>=', now())
            ->count();

        /*
         * Activités récentes.
         */
        $activities = Activite::query()
            ->where('encadrant_id', $encadrant->user_id)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'text' => $activity->description,
                    'time' => $activity->created_at->diffForHumans(),
                ];
            })
            ->values();

        return Inertia::render('Encadrant/Dashboard', [
            'encadrant' => [
                'id' => $user->id,
                'name' => $user->nom_complet,
            ],

            'stats' => [
                'stagiaires' => $stagiairesModels->count(),
                'pendingReviews' => $pendingReviews,
                'meetings' => $meetings,
                'averageProgress' => $stagiaires->isNotEmpty()
                    ? (int) round($stagiaires->avg('progress'))
                    : 0,
            ],

            'stagiaires' => $stagiaires,
            'activities' => $activities,
            'pendingTasks' => $pendingTasks,
        ]);
    }
}
