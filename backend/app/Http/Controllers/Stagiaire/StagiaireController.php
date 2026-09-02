<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Validation\Rules\Password;

class StagiaireController extends Controller
{
    /**
     * Display the authenticated stagiaire profile.
     */
    public function show()
    {
        $user = User::with(['stagiaire', 'ville'])->findOrFail(Auth::id());

        return Inertia::render('Stagiaire/Profile/Show', [
            'stagiaire' => $user,
        ]);
    }

    /**
     * Show the edit form for the profile.
     */
    public function edit()
    {
        $user = User::with(['stagiaire', 'ville'])->findOrFail(Auth::id());
        $villes = Ville::select('id', 'nom')->get();

        return Inertia::render('Stagiaire/Profile/Edit', [
            'stagiaire' => $user,
            'villes'    => $villes,
        ]);
    }

    /**
     * Update the authenticated stagiaire profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom_complet'    => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone'      => 'nullable|string|max:20',
            'ville_id'       => 'required|exists:villes,id',
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

        // Handle Profile Photo Upload
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles/stagiaires', 'public');
        }

        // Update User Details
        $user->update([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'ville_id'    => $request->ville_id,
        ]);

        // Fetch existing stagiaire data to preserve old CV if not uploading a new one
        $stagiaire = Stagiaire::where('user_id', $user->id)->first();
        $cvPath = $stagiaire?->cv_url;

        if ($request->hasFile('cv')) {
            if ($cvPath) {
                Storage::disk('public')->delete($cvPath);
            }
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        // Update or Create Stagiaire Details
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
                'statut_stage'   => $request->statut_stage ?? 'en_recherche',
            ]
        );

        return back()->with('message', 'Internship profile updated successfully.');
    }

    /**
     * Update authenticated Stagiaire password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('message', 'Password updated successfully.');
    }

    /**
     * Delete the authenticated stagiaire account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        // Delete photo & CV files if present
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        if ($user->stagiaire && $user->stagiaire->cv_url) {
            Storage::disk('public')->delete($user->stagiaire->cv_url);
        }

        Auth::logout();

        // Deleting user cascades to stagiaire record
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Your account has been deleted.');
    }
}