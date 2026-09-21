<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{

    public function index(): Response
    {
        $documents = Document::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
            ])
            ->orderByDesc('created_at')
            ->paginate(12);

        return Inertia::render('Encadrant/Documents/Index', [
            'documents' => $documents,
        ]);
    }


    public function download($id)
    {
        $document = Document::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )->findOrFail($id);

        $path = storage_path(
            'app/public/' . $document->fichier_url
        );

        if (! file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download(
            $path,
            $document->nom
        );
    }


    public function updateStatus(
        Request $request,
        $id
    ): RedirectResponse {
        $validated = $request->validate([
            'statut' => [
                'required',
                'in:en_attente,valide,rejete',
            ],
        ]);

        $document = Document::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )->findOrFail($id);

        $document->update([
            'statut' => $validated['statut'],
        ]);

        return back()->with(
            'message',
            'Statut du document mis à jour.'
        );
    }
    public function show($id): Response
    {
        $document = Document::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
            ])
            ->findOrFail($id);

        return Inertia::render('Encadrant/Documents/Show', [
            'document' => $document,
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $document = Document::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )->findOrFail($id);

        $document->delete();

        return back()->with(
            'message',
            'Document supprimé.'
        );
    }


    public function reviews(): Response
    {
        $documents = Document::where(
            'idUtilisateur_Encadrant',
            Auth::id()
        )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
                'stage.taches',
            ])
            ->orderByDesc('created_at')
            ->paginate(10);

        return Inertia::render(
            'Encadrant/TaskReviews/Index',
            [
                'documents' => $documents,
            ]
        );
    }
}
