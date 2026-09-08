<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TacheController extends Controller
{
    /**
     * Display tasks for the logged-in intern's active stage.
     */
    public function index(Request $request): Response
    {
        $stagiaireId = Auth::id();

        $query = Tache::whereHas('stage.candidature', function ($q) use ($stagiaireId) {
            $q->where('idUtilisateur_Stagiaire', $stagiaireId);
        })->with(['encadrant.user', 'stage']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $taches = $query->orderBy('date_echeance', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return Inertia::render('Stagiaire/Taches/Index', [
            'taches'  => $taches,
            'filters' => $request->only(['statut']),
        ]);
    }

    /**
     * Update task progress status (Stagiaire side).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:À faire,En cours,Terminée',
        ]);

        $stagiaireId = Auth::id();

        $tache = Tache::whereHas('stage.candidature', function ($q) use ($stagiaireId) {
            $q->where('idUtilisateur_Stagiaire', $stagiaireId);
        })->findOrFail($id);

        $dateFinEffective = $request->statut === 'Terminée' ? now()->toDateString() : null;

        $tache->update([
            'statut'             => $request->statut,
            'date_fin_effective' => $dateFinEffective,
        ]);

        return back()->with('message', 'Task status updated successfully.');
    }
}