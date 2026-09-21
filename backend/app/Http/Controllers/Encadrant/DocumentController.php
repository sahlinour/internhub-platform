<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    /**
     * Display all documents assigned to the authenticated supervisor.
     */
    public function index(): Response
    {
        $documents = Document::query()
            ->where(
                'idUtilisateur_Encadrant',
                Auth::id()
            )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
            ])
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render(
            'Encadrant/Documents/Index',
            [
                'documents' => $documents,
            ]
        );
    }

    /**
     * Display documents waiting for task review.
     */
    public function reviews(Request $request): Response
    {
        $search = trim(
            (string) $request->query('search', '')
        );

        $status = (string) $request->query(
            'status',
            'all'
        );

        $allowedStatuses = [
            'all',
            'En attente',
            'Validé',
            'Rejeté',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'all';
        }

        $documents = Document::query()
            ->where(
                'idUtilisateur_Encadrant',
                Auth::id()
            )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
                'stage.taches',
            ])

            // Search by document, internship, intern or offer.
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        function ($query) use ($search) {
                            $query
                                ->where(
                                    'nom',
                                    'ilike',
                                    '%' . $search . '%'
                                )
                                ->orWhereHas(
                                    'stage',
                                    function ($stageQuery) use ($search) {
                                        $stageQuery->where(
                                            'sujet',
                                            'ilike',
                                            '%' . $search . '%'
                                        );
                                    }
                                )
                                ->orWhereHas(
                                    'stage.candidature.stagiaire.user',
                                    function ($userQuery) use ($search) {
                                        $userQuery->where(
                                            'nom_complet',
                                            'ilike',
                                            '%' . $search . '%'
                                        );
                                    }
                                )
                                ->orWhereHas(
                                    'stage.candidature.offreDeStage',
                                    function ($offerQuery) use ($search) {
                                        $offerQuery->where(
                                            'titre',
                                            'ilike',
                                            '%' . $search . '%'
                                        );
                                    }
                                );
                        }
                    );
                }
            )

            // Filter by document status.
            ->when(
                $status !== 'all',
                function ($query) use ($status) {
                    $query->where(
                        'statut',
                        $status
                    );
                }
            )
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render(
            'Encadrant/TaskReviews/Index',
            [
                'documents' => $documents,

                'filters' => [
                    'search' => $search,
                    'status' => $status,
                ],
            ]
        );
    }

    /**
     * Display one document for review.
     */
    public function show(int $id): Response
    {
        $document = Document::query()
            ->where(
                'idUtilisateur_Encadrant',
                Auth::id()
            )
            ->with([
                'stage.candidature.stagiaire.user',
                'stage.candidature.offreDeStage',
                'stage.taches',
            ])
            ->findOrFail($id);

        return Inertia::render(
            'Encadrant/Documents/Show',
            [
                'document' => $document,
            ]
        );
    }

    /**
     * Download a document.
     */
    public function download(int $id)
    {
        $document = Document::query()
            ->where(
                'idUtilisateur_Encadrant',
                Auth::id()
            )
            ->findOrFail($id);

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

    /**
     * Update the review status of a document.
     */
    public function updateStatus(
        Request $request,
        int $id
    ): RedirectResponse {
        $validated = $request->validate([
            'statut' => [
                'required',
<<<<<<< HEAD
                'in:en_attente,valide,rejete',
=======
                'string',
                'in:En attente,Validé,Rejeté',
>>>>>>> 3b91466 (Add task  supervisor palette)
            ],
        ]);

        $document = Document::query()
            ->where(
                'idUtilisateur_Encadrant',
                Auth::id()
            )
            ->findOrFail($id);

        $document->update([
            'statut' => $validated['statut'],
        ]);

        return back()->with(
            'message',
            'Document status updated successfully.'
        );
    }

    /**
     * Delete a document.
     */
    public function destroy(int $id): RedirectResponse
    {
        $document = Document::query()
            ->where(
                'idUtilisateur_Encadrant',
                Auth::id()
            )
            ->findOrFail($id);

        $document->delete();

        return back()->with(
            'message',
            'Document deleted successfully.'
        );
    }
}
