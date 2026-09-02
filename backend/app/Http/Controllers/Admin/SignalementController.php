<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class SignalementController extends Controller
{
    /**
     * Display all signalements for Admin.
     */
    public function index(Request $request): Response
    {
        
        $query = Signalement::with(['emetteur', 'admin', 'offreDeStage.entreprise.user']);


        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $signalements = $query->orderBy('created_at', 'desc')
                              ->paginate(15)
                              ->withQueryString();

        return Inertia::render('Admin/Signalements/Index', [
            'signalements' => $signalements,
            'filters'      => $request->only(['statut']),
        ]);
    }

    /**
     * Resolve or dismiss a signalement.
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'statut' => 'required|in:resolved,dismissed,pending',
        ]);

        $signalement = Signalement::findOrFail($id);

        $signalement->update([
            'statut'               => $request->statut,
            'id_Utilisateur_Admin' => Auth::id(), // Assign managing Admin
        ]);

        return back()->with('message', 'Status of the report updated.');
    }
}