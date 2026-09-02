<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class DocumentController extends Controller
{
    /**
     * Display documents attached to the logged-in intern's stage.
     */
    public function index(): Response
    {
        $stagiaireId = Auth::id();

        $documents = Document::whereHas('stage.candidature', function ($q) use ($stagiaireId) {
            $q->where('idUtilisateur_Stagiaire', $stagiaireId);
        })->with(['encadrant.user', 'stage'])
          ->orderBy('created_at', 'desc')
          ->paginate(10);

        return Inertia::render('Stagiaire/Documents/Index', [
            'documents' => $documents,
        ]);
    }

    /**
     * Upload a new document for a stage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_Stage' => 'required|exists:stages,id',
            'nom'      => 'required|string|max:255',
            'version'  => 'nullable|string|max:10',
            'fichier'  => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240',
        ]);

        $stagiaireId = Auth::id();

        $stage = Stage::whereHas('candidature', function ($q) use ($stagiaireId) {
            $q->where('idUtilisateur_Stagiaire', $stagiaireId);
        })->findOrFail($request->id_Stage);

        $path = $request->file('fichier')->store('documents', 'public');

        Document::create([
            'nom'                      => $request->nom,
            'version'                  => $request->version ?? 'v1.0',
            'statut'                   => 'En attente',
            'fichier_url'              => $path,
            'id_Utilisateur_encadrant' => $stage->idUtilisateur_Encadrant,
            'id_Stage'                 => $stage->id,
        ]);

        return back()->with('message', 'Document uploaded successfully.');
    }
}