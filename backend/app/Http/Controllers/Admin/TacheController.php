<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TacheController extends Controller
{
    /**
     * List all tasks across the platform.
     */
    public function index(Request $request): Response
    {
        $query = Tache::with([
            'encadrant.user',
            'stage.candidature.stagiaire.user',
            'stage.candidature.offreDeStage.entreprise.user'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $taches = $query->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        return Inertia::render('Admin/Taches/Index', [
            'taches'  => $taches,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Force delete a task.
     */
    public function destroy($id): RedirectResponse
    {
        $tache = Tache::findOrFail($id);
        $tache->delete();

        return back()->with('message', 'Tâche supprimée par l\'administrateur.');
    }
}