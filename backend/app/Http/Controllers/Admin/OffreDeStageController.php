<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class OffreDeStageController extends Controller
{
    /**
     * Display a paginated list of all internship offers for the Admin.
     * 
     * Includes filtering by title search and offer status, along with
     * Eager Loading of the associated Entreprise and User models.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        // Build query with relationships (Offredestage -> Entreprise -> User)
        $query = Offredestage::with(['entreprise.user']);

        // Filter by title keyword if present
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('titre', 'like', "%{$search}%");
        }

        // Filter by offer status (active, inactive, closed) if present
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Fetch paginated results and retain query params in pagination links
        $offres = $query->orderBy('created_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        // Render Vue 3 Inertia page with offers data and active filters
        return Inertia::render('Admin/Offres/Index', [
            'offres'  => $offres,
            'filters' => $request->only(['search', 'statut']),
        ]);
    }

    /**
     * Update the publication status of a specific internship offer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        // Validate that the requested status is an allowed value
        $request->validate([
            'statut' => 'required|in:active,inactive,closed',
        ]);

        // Find offer or return 404
        $offre = Offredestage::findOrFail($id);

        // Update status field
        $offre->update([
            'statut' => $request->statut,
        ]);

        // Return back to page with success feedback message
        return back()->with('message', 'Offer status updated by the administrator.');
    }

    /**
     * Delete (Soft Delete) an internship offer from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        // Find offer or fail with 404
        $offre = Offredestage::findOrFail($id);

        // Soft delete the offer record
        $offre->delete();

        // Redirect back with success message
        return back()->with('message', 'Internship offer removed by the administrator.');
    }
}