<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class FavorisController extends Controller
{
    /**
     * Display a paginated list of bookmarked internship offers for the Stagiaire.
     */
    public function index(): Response
    {
        $stagiaire = Auth::user()->stagiaire;

        // Fetch bookmarked offers along with company details
        $favoris = $stagiaire->favoris()
            ->with(['entreprise.user', 'entreprise.user.ville'])
            ->orderBy('favoris.created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Stagiaire/Favoris/Index', [
            'favoris' => $favoris,
        ]);
    }

    /**
     * Toggle bookmark status for an offer (Add if absent, Remove if present).
     */
    public function toggle($offreId): RedirectResponse
    {
        // Ensure the offer exists and is active
        $offre = Offredestage::findOrFail($offreId);
        $stagiaire = Auth::user()->stagiaire;

        // Toggle relationship in the favoris pivot table
        $changes = $stagiaire->favoris()->toggle($offre->id);

        $message = count($changes['attached']) > 0
            ? 'Offer added to your favorites.'
            : 'Offer removed from your favorites.';

        return back()->with('message', $message);
    }

    /**
     * Explicitly remove an offer from favoris.
     */
    public function destroy($offreId): RedirectResponse
    {
        $stagiaire = Auth::user()->stagiaire;
        $stagiaire->favoris()->detach($offreId);

        return back()->with('message', 'Offer removed from your favorites.');
    }
}