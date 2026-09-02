<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Offredestage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OffreDeStageController extends Controller
{
    public function index()
    {
        $entrepriseId = Auth::id();

        $offres = Offredestage::where('idUtilisateur_Entreprise', $entrepriseId)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Entreprise/Offres/Index', [
            'offres' => $offres,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'duree'       => 'required|string|max:255',
            'date_limite'  => 'required|date|after_or_equal:today',
            'statut'      => 'required|in:active,inactive,closed',
        ]);

        Offredestage::create([
            'titre'                    => $request->titre,
            'description'              => $request->description,
            'duree'                    => $request->duree,
            'date_limite'               => $request->date_limite,
            'statut'                   => $request->statut,
            'idUtilisateur_Entreprise' => Auth::id(),
        ]);

        return back()->with('message', 'Internship offer created successfully.');
    }

    public function update(Request $request, $id)
    {
        $entrepriseId = Auth::id();

        $offre = Offredestage::where('idUtilisateur_Entreprise', $entrepriseId)->findOrFail($id);

        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'duree'       => 'required|string|max:255',
            'date_limite'  => 'required|date',
            'statut'      => 'required|in:active,inactive,closed',
        ]);

        $offre->update($request->only(['titre', 'description', 'duree', 'date_limite', 'statut']));

        return back()->with('message', 'Updated internship offer.');
    }

    public function destroy($id)
    {
        $entrepriseId = Auth::id();

        $offre = Offredestage::where('idUtilisateur_Entreprise', $entrepriseId)->findOrFail($id);
        $offre->delete();

        return back()->with('message', 'Internship offer removed.');
    }
}