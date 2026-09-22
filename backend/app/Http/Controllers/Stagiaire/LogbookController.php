<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Stage;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LogbookController extends Controller
{
    /**
     * Display the logged-in intern's weekly logbook.
     */
    public function index(): Response
    {
        $stagiaireId = Auth::id();

        $stage = Stage::whereHas('candidature', function ($query) use ($stagiaireId) {
            $query->where('idUtilisateur_Stagiaire', $stagiaireId);
        })
            ->with([
                'encadrant.user',
                'candidature.offreDeStage.entreprise.user',
            ])
            ->latest()
            ->first();

        /*
         * No active internship.
         */
        if (!$stage) {
            return Inertia::render('Stagiaire/Logbook/Index', [
                'stage'          => null,
                'weeklyTasks'    => [],
                'availableTasks' => [],
                'evaluation'     => null,
            ]);
        }

        /*
         * Get all tasks assigned to the current internship.
         * These tasks are also sent to the "New Weekly Entry" modal.
         */
        $tasks = Tache::where('id_Stage', $stage->id)
            ->orderBy('date_creation', 'asc')
            ->get();

        /*
         * Get the latest evaluation of the internship.
         */
        $evaluation = Evaluation::where('id_Stage', $stage->id)
            ->latest('date_evaluation')
            ->first();

        /*
         * Group tasks by internship week according to their creation date.
         *
         * Example:
         * Week 1 = 03 Sep → 09 Sep
         * Week 2 = 10 Sep → 16 Sep
         * Week 3 = 17 Sep → 23 Sep
         */
        $weeklyTasks = $tasks
            ->groupBy(function ($task) use ($stage) {
                $start = $stage->date_debut->copy()->startOfDay();

                $taskDate = $task->date_creation->copy()->startOfDay();

                $daysSinceStart = $start->diffInDays($taskDate, false);

                /*
                 * Tasks created before the internship start
                 * are placed in Week 1.
                 */
                if ($daysSinceStart < 0) {
                    return 1;
                }

                return intdiv($daysSinceStart, 7) + 1;
            })
            ->map(function ($weekTasks, $weekNumber) use ($stage) {
                $weekStart = $stage->date_debut
                    ->copy()
                    ->startOfDay()
                    ->addWeeks($weekNumber - 1);

                $weekEnd = $weekStart->copy()->addDays(6);

                /*
                 * The last week cannot go beyond the internship end date.
                 */
                if ($weekEnd->greaterThan($stage->date_fin)) {
                    $weekEnd = $stage->date_fin->copy()->startOfDay();
                }

                return [
                    'week'       => (int) $weekNumber,
                    'start_date' => $weekStart->toDateString(),
                    'end_date'   => $weekEnd->toDateString(),
                    'tasks'      => $weekTasks->values(),
                ];
            })
            ->sortBy('week')
            ->values();

        return Inertia::render('Stagiaire/Logbook/Index', [
            'stage'          => $stage,
            'weeklyTasks'    => $weeklyTasks,
            'availableTasks' => $tasks,
            'evaluation'     => $evaluation,
        ]);
    }
}
