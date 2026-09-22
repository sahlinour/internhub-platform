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

class InternshipJourneyController extends Controller
{
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
            ->latest()
            ->first();

        if (!$stage) {
            return Inertia::render('Stagiaire/InternshipJourney/Index', [
                'stage' => null,
                'tasks' => [],
                'documents' => [],
                'evaluation' => null,
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

        return Inertia::render('Stagiaire/InternshipJourney/Index', [
            'stage' => $stage,
            'tasks' => $tasks,
            'documents' => $documents,
            'evaluation' => $evaluation,
        ]);
    }
}