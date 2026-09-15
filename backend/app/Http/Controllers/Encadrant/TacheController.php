<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TacheController extends Controller
{
    /**
     * Display tasks created/supervised by the logged-in Encadrant.
     */
    public function index(Request $request): Response
    {
        $encadrantId = Auth::id();

        $query = Tache::where('idUtilisateur_Encadrant', $encadrantId)
            ->with(['stage.candidature.stagiaire.user']);

        if ($request->filled('stage_id')) {
            $query->where('id_Stage', $request->stage_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $taches = $query->orderBy('date_echeance', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        // Stages supervised by this encadrant to populate filter dropdowns or create modals
        $stages = Stage::where('idUtilisateur_Encadrant', $encadrantId)
            ->with('candidature.stagiaire.user')
            ->get();

        return Inertia::render('Encadrant/Taches/Index', [
            'taches'  => $taches,
            'stages'  => $stages,
            'filters' => $request->only(['stage_id', 'statut']),
        ]);
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_Stage'           => 'required|exists:stages,id',
            'titre'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'priorite'           => 'required|in:Basse,Moyenne,Haute,Urgente',
            'date_echeance'      => 'required|date|after_or_equal:today',
        ]);

        $encadrantId = Auth::id();

        // Ensure the stage belongs to this encadrant
        $stage = Stage::where('id', $request->id_Stage)
            ->where('idUtilisateur_Encadrant', $encadrantId)
            ->findOrFail();

        Tache::create([
            'titre'                    => $request->titre,
            'description'              => $request->description,
            'priorite'                 => $request->priorite,
            'date_creation'            => now()->toDateString(),
            'date_echeance'            => $request->date_echeance,
            'statut'                   => 'À faire',
            'idUtilisateur_Encadrant' => $encadrantId,
            'id_Stage'                 => $stage->id,
        ]);

        return back()->with('message', 'Tâche créée avec succès.');
    }

    /**
     * Update an existing task.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'titre'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'priorite'           => 'required|in:Basse,Moyenne,Haute,Urgente',
            'date_echeance'      => 'required|date',
            'statut'             => 'required|in:À faire,En cours,Terminée,Annulée',
        ]);

        $encadrantId = Auth::id();
        $tache = Tache::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);

        $dateFinEffective = $request->statut === 'Terminée' && $tache->statut !== 'Terminée' 
            ? now()->toDateString() 
            : $tache->date_fin_effective;

        if ($request->statut !== 'Terminée') {
            $dateFinEffective = null;
        }

        $tache->update([
            'titre'              => $request->titre,
            'description'        => $request->description,
            'priorite'           => $request->priorite,
            'date_echeance'      => $request->date_echeance,
            'statut'             => $request->statut,
            'date_fin_effective' => $dateFinEffective,
        ]);

        return back()->with('message', 'Tâche mise à jour avec succès.');
    }

    /**
     * Delete a task.
     */
    public function destroy($id): RedirectResponse
    {
        $encadrantId = Auth::id();
        $tache = Tache::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);
        $tache->delete();

        return back()->with('message', 'Tâche supprimée avec succès.');
    }
}