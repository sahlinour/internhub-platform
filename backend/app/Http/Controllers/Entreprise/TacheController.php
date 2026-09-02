<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TacheController extends Controller
{
    /**
     * List all tasks belonging to company internship stages.
     */
    public function index(Request $request): Response
    {
        $entrepriseId = Auth::id();

        $query = Tache::whereHas('stage.candidature.offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->with(['stage.candidature.stagiaire.user', 'encadrant.user']);

        if ($request->filled('stage_id')) {
            $query->where('id_Stage', $request->stage_id);
        }

        $taches = $query->orderBy('date_echeance', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        return Inertia::render('Entreprise/Taches/Index', [
            'taches'  => $taches,
            'filters' => $request->only(['stage_id']),
        ]);
    }
}