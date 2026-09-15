<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class DocumentController extends Controller
{
    /**
     * List documents supervised by the logged-in Encadrant.
     */
    public function index(): Response
    {
        $encadrantId = Auth::id();

        $documents = Document::where('idUtilisateur_Encadrant', $encadrantId)
            ->with(['stage.candidature.stagiaire.user', 'stage.candidature.offreDeStage'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return Inertia::render('Encadrant/Documents/Index', [
            'documents' => $documents,
        ]);
    }

    /**
     * Update document status (e.g., Validé or Rejeté).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:En attente,Validé,Rejeté',
        ]);

        $encadrantId = Auth::id();

        $document = Document::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);
        $document->update(['statut' => $request->statut]);

        return back()->with('message', 'Statut du document mis à jour.');
    }

    /**
     * Delete a document.
     */
    public function destroy($id): RedirectResponse
    {
        $encadrantId = Auth::id();

        $document = Document::where('idUtilisateur_Encadrant', $encadrantId)->findOrFail($id);
        $document->delete();

        return back()->with('message', 'Document supprimé.');
    }
}