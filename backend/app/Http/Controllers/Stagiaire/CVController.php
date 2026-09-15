<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CVController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Stagiaire']);
    }

    /**
     * Display a listing of CVs for the authenticated stagiaire.
     */
    public function index(): Response
    {
        $stagiaireId = Auth::id();

        // Get all CVs uploaded by the stagiaire (not necessarily tied to a stage)
        $cvs = Document::where('id_Utilisateur_stagiaire', $stagiaireId)
            ->where('type', 'cv')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Stagiaire/CV/Index', [
            'cvs' => $cvs,
        ]);
    }

    /**
     * Show the form for creating a new CV.
     */
    public function create(): Response
    {
        return Inertia::render('Stagiaire/CV/Create');
    }

    /**
     * Store a newly created CV in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom'      => 'required|string|max:255',
            'version'  => 'nullable|string|max:10',
            'fichier'  => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $stagiaireId = Auth::id();
        $path = $request->file('fichier')->store('cvs', 'public');

        Document::create([
            'nom'                      => $request->nom,
            'version'                  => $request->version ?? '1.0',
            'type'                     => 'cv',
            'statut'                   => 'En attente',
            'fichier_url'              => $path,
            'id_Utilisateur_stagiaire' => $stagiaireId,
        ]);

        return redirect()
            ->route('stagiaire.cv.index')
            ->with('success', 'CV uploaded successfully.');
    }

    /**
     * Delete a CV from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $stagiaireId = Auth::id();

        $cv = Document::where('id', $id)
            ->where('id_Utilisateur_stagiaire', $stagiaireId)
            ->firstOrFail();

        $cv->delete();

        return back()->with('success', 'CV deleted successfully.');
    }
}
