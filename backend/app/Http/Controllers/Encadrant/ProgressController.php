<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProgressController extends Controller
{
    public function index(): Response
    {
        $stages = Stage::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )
            ->with([
                'candidature.stagiaire.user',
                'taches',
            ])
            ->get();

        $interns = $stages->map(function ($stage) {

            $totalTasks = $stage->taches->count();

            $completedTasks = $stage->taches
                ->where('statut', 'Terminée')
                ->count();

            $progress = $totalTasks > 0
                ? round(($completedTasks / $totalTasks) * 100)
                : 0;

            return [
                'stage_id' => $stage->id,

                'stage' => [
                    'sujet' => $stage->sujet,
                    'date_debut' => $stage->date_debut,
                    'date_fin' => $stage->date_fin,
                ],

                'intern' => $stage
                    ->candidature
                    ?->stagiaire
                    ?->user,

                'total_tasks' => $totalTasks,

                'completed_tasks' => $completedTasks,

                'progress' => $progress,
            ];
        });

        return Inertia::render(
            'Encadrant/Progress/Index',
            [
                'interns' => $interns,
            ]
        );
    }
}
