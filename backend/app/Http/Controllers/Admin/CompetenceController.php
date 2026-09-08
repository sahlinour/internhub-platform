<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CompetenceController extends Controller
{
    /**
     * Display a paginated list of global competences.
     */
    public function index(Request $request): Response
    {
        $query = Competence::withCount('stagiaires');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom_competence', 'like', "%{$search}%");
        }

        $competences = $query->orderBy('nom_competence', 'asc')
                             ->paginate(10)
                             ->withQueryString();

        return Inertia::render('Admin/Competences/Index', [
            'competences' => $competences,
            'filters'     => $request->only(['search']),
        ]);
    }

    /**
     * Store a new global competence.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom_competence' => 'required|string|max:255|unique:competences,nom_competence',
        ]);

        Competence::create([
            'nom_competence' => trim($request->nom_competence),
        ]);

        return back()->with('message', 'Skill successfully created.');
    }

    /**
     * Update an existing global competence name.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $competence = Competence::findOrFail($id);

        $request->validate([
            'nom_competence' => 'required|string|max:255|unique:competences,nom_competence,' . $id,
        ]);

        $competence->update([
            'nom_competence' => trim($request->nom_competence),
        ]);

        return back()->with('message', 'Skill updated successfully.');
    }

    /**
     * Delete a global competence.
     */
    public function destroy($id): RedirectResponse
    {
        $competence = Competence::findOrFail($id);
        $competence->delete();

        return back()->with('message', 'Skill removed successfully.');
    }
}