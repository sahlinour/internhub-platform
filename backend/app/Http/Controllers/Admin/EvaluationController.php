<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EvaluationController extends Controller
{
    /**
     * Display all evaluations across the platform.
     */
    public function index(Request $request): Response
    {
        $query = Evaluation::with([
            'encadrant.user',
            'stage.candidature.stagiaire.user',
            'stage.candidature.offreDeStage.entreprise.user'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('stage.candidature.stagiaire.user', fn($q) => $q->where('nom_complet', 'like', "%{$search}%"))
                  ->orWhereHas('encadrant.user', fn($q) => $q->where('nom_complet', 'like', "%{$search}%"));
        }

        $evaluations = $query->orderBy('created_at', 'desc')
                            ->paginate(15)
                            ->withQueryString();

        return Inertia::render('Admin/Evaluations/Index', [
            'evaluations' => $evaluations,
            'filters'     => $request->only(['search']),
        ]);
    }

    /**
     * Delete an evaluation.
     */
    public function destroy($id): RedirectResponse
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();

        return back()->with('message', 'Review removed by administrator.');
    }
}