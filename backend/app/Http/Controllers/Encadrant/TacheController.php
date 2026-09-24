<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use App\Models\Tache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TacheController extends Controller
{
    public function index(Request $request): Response
    {
        $encadrantId = Auth::id();

        $query = Tache::where('idUtilisateur_Encadrant', $encadrantId)
            ->with('stage.candidature.stagiaire.user');

        if ($request->filled('stage_id')) {
            $query->where('id_Stage', $request->input('stage_id'));
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        $taches = $query
            ->orderBy('date_echeance')
            ->paginate(10)
            ->withQueryString();

        $stages = Stage::where('idUtilisateur_Encadrant', $encadrantId)
            ->with('candidature.stagiaire.user')
            ->get();

        return Inertia::render('Encadrant/Taches/Index', [
            'taches' => $taches,
            'stages' => $stages,
            'filters' => $request->only(['stage_id', 'statut']),
        ]);
    }

    public function create(Request $request): Response
    {
        $stages = Stage::where('idUtilisateur_Encadrant', Auth::id())
            ->with([
                'candidature.stagiaire.user',
                'candidature.offreDeStage',
            ])
            ->orderBy('date_debut', 'desc')
            ->get();

        $selectedStageId = $request->query('stage');

        if ($selectedStageId !== null) {
            $belongsToEncadrant = $stages->contains(
                fn ($stage) => (string) $stage->id === (string) $selectedStageId
            );

            abort_unless($belongsToEncadrant, 403);
        }

        return Inertia::render('Encadrant/Taches/Create', [
            'stages' => $stages,
            'selectedStageId' => $selectedStageId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priorite' => ['required', 'in:Low,Medium,High,Urgent'],
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_echeance' => ['required', 'date', 'after_or_equal:date_debut'],
            'id_Stage' => ['required', 'exists:stages,id'],
        ]);

        $stage = Stage::where('id', $validated['id_Stage'])
            ->where('idUtilisateur_Encadrant', Auth::id())
            ->firstOrFail();

        Tache::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'priorite' => $validated['priorite'],
            'date_creation' => now()->toDateString(),
            'date_debut' => $validated['date_debut'],
            'date_echeance' => $validated['date_echeance'],
            'statut' => 'todo',
            'idUtilisateur_Encadrant' => Auth::id(),
            'id_Stage' => $stage->id,
        ]);

        return redirect()
            ->route('encadrant.taches.index')
            ->with('message', 'Task assigned successfully.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $tache = Tache::where('idUtilisateur_Encadrant', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priorite' => ['required', 'in:Low,Medium,High,Urgent'],
            'date_echeance' => ['required', 'date'],
            'statut' => ['required', 'in:todo,in_progress,completed,cancelled'],
        ]);

        $dateFinEffective = $validated['statut'] === 'completed'
            ? ($tache->statut === 'completed'
                ? $tache->date_fin_effective
                : now()->toDateString())
            : null;

        $tache->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'priorite' => $validated['priorite'],
            'date_echeance' => $validated['date_echeance'],
            'statut' => $validated['statut'],
            'date_fin_effective' => $dateFinEffective,
        ]);

        return back()->with('message', 'Task updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $tache = Tache::where('idUtilisateur_Encadrant', Auth::id())
            ->findOrFail($id);

        $tache->delete();

        return back()->with('message', 'Task deleted successfully.');
    }
}
