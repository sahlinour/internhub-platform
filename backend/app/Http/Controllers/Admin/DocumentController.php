<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class DocumentController extends Controller
{
    /**
     * List all documents across the system.
     */
    public function index(Request $request): Response
    {
        $query = Document::with([
            'encadrant.user',
            'stage.candidature.stagiaire.user',
            'stage.candidature.offreDeStage.entreprise.user'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhereHas('stage.candidature.stagiaire.user', fn($q) => $q->where('nom_complet', 'like', "%{$search}%"));
        }

        $documents = $query->orderBy('created_at', 'desc')
                           ->paginate(15)
                           ->withQueryString();

        return Inertia::render('Admin/Documents/Index', [
            'documents' => $documents,
            'filters'   => $request->only(['search']),
        ]);
    }

    /**
     * Force delete a document.
     */
    public function destroy($id): RedirectResponse
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return back()->with('message', 'Document deleted by the administrator.');
    }
}