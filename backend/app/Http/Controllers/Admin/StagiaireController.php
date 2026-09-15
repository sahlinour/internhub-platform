<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StagiaireController extends Controller
{
    /**
     * Display a listing of all stagiaires with search and status filtering.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'stagiaire')
            ->with(['stagiaire', 'ville']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom_complet', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        $stagiaires = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Stagiaires/Index', [
            'stagiaires' => $stagiaires,
            'filters'    => $request->only(['search', 'etat']),
        ]);
    }

    /**
     * Display details of a specific stagiaire.
     */
    public function show($id)
    {
        $user = User::where('role', 'stagiaire')
            ->with(['stagiaire', 'ville'])
            ->findOrFail($id);

        return Inertia::render('Admin/Stagiaires/Show', [
            'stagiaire' => $user,
        ]);
    }

    /**
     * Show edit form for a stagiaire.
     */
    public function edit($id)
    {
        $user = User::where('role', 'stagiaire')
            ->with(['stagiaire', 'ville'])
            ->findOrFail($id);

        $villes = Ville::select('id', 'nom')->get();

        return Inertia::render('Admin/Stagiaires/Edit', [
            'stagiaire' => $user,
            'villes'    => $villes,
        ]);
    }

    /**
     * Update a stagiaire's account and profile data.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'stagiaire')->findOrFail($id);

        $request->validate([
            'nom_complet'    => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone'      => 'nullable|string|max:20',
            'ville_id'       => 'required|exists:villes,id',
            'etat'           => 'required|in:pending,active,block',
            'universite'     => 'nullable|string|max:255',
            'filiere'        => 'nullable|string|max:255',
            'niveau'         => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'cv'             => 'nullable|file|mimes:pdf,doc,docx|max:5000',
            'linkedin_url'   => 'nullable|url|max:255',
            'portfolio_url'  => 'nullable|url|max:255',
            'statut_stage'   => 'nullable|string|max:255',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles/stagiaires', 'public');
        }

        $user->update([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'ville_id'    => $request->ville_id,
            'etat'        => $request->etat,
        ]);

        $stagiaire = Stagiaire::where('user_id', $user->id)->first();
        $cvPath = $stagiaire?->cv_url;

        if ($request->hasFile('cv')) {
            if ($cvPath) {
                Storage::disk('public')->delete($cvPath);
            }
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        Stagiaire::updateOrCreate(
            ['user_id' => $user->id],
            [
                'universite'     => $request->universite,
                'filiere'        => $request->filiere,
                'niveau'         => $request->niveau,
                'date_naissance' => $request->date_naissance,
                'cv_url'         => $cvPath,
                'linkedin_url'   => $request->linkedin_url,
                'portfolio_url'  => $request->portfolio_url,
                'statut_stage'   => $request->statut_stage ?? 'recherche',
            ]
        );

        return redirect()->route('admin.stagiaires.index')
            ->with('message', 'Trainee successfully updated.');
    }
    
    /**
     * Admin force resets a Stagiaire user password (no current password required).
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = User::where('role', 'stagiaire')->findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('message', "The password for trainee {$user->nom_complet} has been reset.");
    }

    /**
     * Update only the state ('pending', 'active', 'block') of a stagiaire.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'etat' => 'required|in:pending,active,block',
        ]);

        $user = User::where('role', 'stagiaire')->findOrFail($id);
        $user->update(['etat' => $request->etat]);

        return back()->with('message', "The status of the trainee has been updated to '{$request->etat}'.");
    }

    /**
     * Delete a stagiaire account and associated files.
     */
    public function destroy($id)
    {
        $user = User::where('role', 'stagiaire')->with('stagiaire')->findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        if ($user->stagiaire && $user->stagiaire->cv_url) {
            Storage::disk('public')->delete($user->stagiaire->cv_url);
        }

        $user->delete();

        return redirect()->route('admin.stagiaires.index')
            ->with('message', 'Trainee removed from the system.');
    }
}