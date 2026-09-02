<?php

namespace App\Http\Controllers;

use App\Models\Offredestage;
use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SignalementController extends Controller
{
    /**
     * Submit a report for an offer.
     */
    public function store(Request $request, $offreId): RedirectResponse
    {
        $request->validate([
            'raison' => 'required|string|max:1000',
        ]);

        $offre = Offredestage::findOrFail($offreId);

        Signalement::create([
            'raison'                 => $request->raison,
            'date_signalement'       => now(),
            'statut'                 => 'pending',
            'idUtilisateur_emetteur' => Auth::id(),
            'id_Offre_De_Stage'      => $offre->id,
        ]);

        return back()->with('message', 'Report successfully sent. An administrator will review it.');
    }
}