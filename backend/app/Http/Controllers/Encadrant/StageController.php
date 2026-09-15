<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class StageController extends Controller
{
    /**
     * Display a list of internships supervised by the logged-in Encadrant.
     */
    public function index(Request $request): Response
    {
        $encadrantId = Auth::id();

        $query = Stage::where('idUtilisateur_Encadrant', $encadrantId)
            ->with([
                'candidature.stagiaire.user',
                'candidature.offreDeStage.entreprise.user',
                'taches',
                'documents',
            ]);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sujet', 'like', "%{$search}%")
                  ->orWhereHas('candidature.stagiaire.user', function ($sq) use ($search) {
                      $sq->where('nom_complet', 'like', "%{$search}%");
                  });
            });
        }

        $stages = $query->orderBy('date_debut', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return Inertia::render('Encadrant/Stages/Index', [
            'stages'  => $stages,
            'filters' => $request->only(['statut', 'search']),
        ]);
    }

    /**
     * Display details of a specific supervised internship.
     */
    public function show($id): Response
    {
        $encadrantId = Auth::id();

        $stage = Stage::where('idUtilisateur_Encadrant', $encadrantId)
            ->with([
                'candidature.stagiaire.user',
                'candidature.offreDeStage.entreprise.user',
                'taches' => fn($q) => $q->orderBy('date_echeance', 'asc'),
                'documents' => fn($q) => $q->latest(),
            ])
            ->findOrFail($id);

        return Inertia::render('Encadrant/Stages/Show', [
            'stage' => $stage,
        ]);
    }

    /**
     * Update internship topic or schedule.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'sujet'      => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after:date_debut',
            'statut'     => 'required|in:En cours,Terminé,Annulé,En attente',
        ]);

        $encadrantId = Auth::id();

        $stage = Stage::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);

        $stage->update([
            'sujet'      => $request->sujet,
            'date_debut' => $request->date_debut,
            'date_fin'   => $request->date_fin,
            'statut'     => $request->statut,
        ]);

        return back()->with('message', 'Le stage a été mis à jour avec succès.');
    }

    /**
     * Quickly update the internship status (e.g., mark as Terminé).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:En cours,Terminé,Annulé,En attente',
        ]);

        $encadrantId = Auth::id();

        $stage = Stage::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);
        $stage->update(['statut' => $request->statut]);

        return back()->with('message', 'Statut du stage mis à jour.');
    }
}