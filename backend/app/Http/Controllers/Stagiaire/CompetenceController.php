<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CompetenceController extends Controller
{
    /**
     * Display skills assigned to the logged-in Stagiaire.
     */
    public function index(): Response
    {
        $stagiaire = Auth::user()->stagiaire()->with('competences')->firstOrFail();
        $allCompetences = Competence::orderBy('nom_competence', 'asc')->get();

        return Inertia::render('Stagiaire/Competences/Index', [
            'my_competences'  => $stagiaire->competences,
            'all_competences' => $allCompetences,
        ]);
    }

    /**
     * Attach a skill to the Stagiaire's profile (creates competence if missing).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom_competence' => 'required|string|max:255',
            'niveau'         => 'required|string|max:255',
            'experience'     => 'nullable|string|max:255',
        ]);

        // Find existing skill or create a new entry in master table
        $competence = Competence::firstOrCreate([
            'nom_competence' => trim($request->nom_competence),
        ]);

        $stagiaire = Auth::user()->stagiaire;

        // Attach skill with pivot metadata matching ERD
        $stagiaire->competences()->syncWithoutDetaching([
            $competence->id => [
                'niveau'     => $request->niveau,
                'experience' => $request->experience,
                'date_ajout' => now(),
            ]
        ]);

        return back()->with('message', 'Skill added to your profile.');
    }

    /**
     * Update level or experience pivot values for an existing skill.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'niveau'     => 'required|string|max:255',
            'experience' => 'nullable|string|max:255',
        ]);

        $stagiaire = Auth::user()->stagiaire;

        $stagiaire->competences()->updateExistingPivot($id, [
            'niveau'     => $request->niveau,
            'experience' => $request->experience,
        ]);

        return back()->with('message', 'Skill updated successfully.');
    }

    /**
     * Detach (Remove) a skill from the Stagiaire profile.
     */
    public function destroy($id): RedirectResponse
    {
        $stagiaire = Auth::user()->stagiaire;
        $stagiaire->competences()->detach($id);

        return back()->with('message', 'Skill removed from your profile.');
    }
}