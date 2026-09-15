<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class StageController extends Controller
{
    /**
     * Display a paginated list of all system stages.
     */
    public function index(Request $request): Response
    {
        $query = Stage::with([
            'candidature.stagiaire.user',
            'candidature.offreDeStage.entreprise.user',
            'encadrant.user'
        ]);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sujet', 'like', "%{$search}%")
                  ->orWhereHas('candidature.stagiaire.user', fn($sq) => $sq->where('nom_complet', 'like', "%{$search}%"));
            });
        }

        $stages = $query->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        return Inertia::render('Admin/Stages/Index', [
            'stages'  => $stages,
            'filters' => $request->only(['statut', 'search']),
        ]);
    }

    /**
     * Update the status of any stage.
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:En cours,Terminée,Annulée',
        ]);

        $stage = Stage::findOrFail($id);
        $stage->update(['statut' => $request->statut]);//En cours,Terminée,Annulée

        return back()->with('message', 'Stage status updated by the administrator.');
    }

    /**
     * Delete a stage record.
     */
    public function destroy($id): RedirectResponse
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();

        return back()->with('message', 'Stage removed by the administrator.');
    }
}