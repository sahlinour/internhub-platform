<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    /**
     * Display all documents associated with internships belonging to the company.
     */
    public function index(Request $request): Response
    {
        $entrepriseId = Auth::id();

        $query = Document::whereHas('stage.candidature.offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->with(['stage.candidature.stagiaire.user', 'encadrant.user']);

        if ($request->filled('stage_id')) {
            $query->where('id_Stage', $request->stage_id);
        }

        $documents = $query->orderBy('created_at', 'desc')
                           ->paginate(15)
                           ->withQueryString();

        return Inertia::render('Entreprise/Documents/Index', [
            'documents' => $documents,
            'filters'   => $request->only(['stage_id']),
        ]);
    }
}