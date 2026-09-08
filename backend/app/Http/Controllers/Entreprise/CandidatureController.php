<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CandidatureController extends Controller
{
    /**
     * List all applications received for the company's offers.
     */
    public function index(Request $request): Response
    {
        $entrepriseId = Auth::id();

        $query = Candidature::whereHas('offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->with(['stagiaire.user', 'stagiaire.competences', 'offreDeStage']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('offre_id')) {
            $query->where('id_Offre_De_Stage', $request->offre_id);
        }

        $candidatures = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Entreprise/Candidatures/Index', [
            'candidatures' => $candidatures,
            'filters'      => $request->only(['statut', 'offre_id']),
        ]);
    }

    /**
     * Update candidate status (e.g. Accept or Reject).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        $entrepriseId = Auth::id();

        $candidature = Candidature::whereHas('offreDeStage', function ($q) use ($entrepriseId) {
            $q->where('idUtilisateur_Entreprise', $entrepriseId);
        })->findOrFail($id);

        $candidature->update([
            'statut' => $request->statut,
        ]);

        return back()->with('message', 'Application status updated.');
    }
}