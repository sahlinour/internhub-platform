<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Validation\Rules\Password;

class EntrepriseController extends Controller
{
    /**
     * Show the profile details for the authenticated Entreprise.
     */
    public function show()
    {
        $user = User::with(['entreprise', 'ville'])->findOrFail(Auth::id());

        return Inertia::render('Entreprise/Profile/Show', [
            'entreprise' => $user,
        ]);
    }

    /**
     * Show the edit form for the profile.
     */
    public function edit()
    {
        $user = User::with(['entreprise', 'ville'])->findOrFail(Auth::id());
        $villes = Ville::select('id', 'nom')->get();

        return Inertia::render('Entreprise/Profile/Edit', [
            'entreprise' => $user,
            'villes'     => $villes,
        ]);
    }

    /**
     * Update the authenticated Entreprise profile and user details.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone'   => 'nullable|string|max:20',
            'ville_id'    => 'required|exists:villes,id',
            'secteur'     => 'required|string|max:255',
            'adresse'     => 'required|string|max:255',
            'site_web'    => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles/entreprises', 'public');
        }

        // Update User Model Attributes
        $user->update([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'ville_id'    => $request->ville_id,
        ]);

        // Update or Create Entreprise Model Attributes
        Entreprise::updateOrCreate(
            ['user_id' => $user->id],
            [
                'secteur'     => $request->secteur,
                'adresse'     => $request->adresse,
                'site_web'    => $request->site_web,
                'description' => $request->description,
            ]
        );

        return back()->with('message', 'Company profile updated successfully.');
    }

    /**
     * Update the authenticated Entreprise user's password.
     * Requires verifying the current (old) password.
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

        return back()->with('message', 'Your password has been updated successfully.');
    }

    /**
     * Delete the authenticated Entreprise account and associated files (when past true password !!!!!!!!).
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

        // Delete profile photo if present
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        Auth::logout();

        // Deleting the User record cascades/deletes the Entreprise record
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Your enterprise account has been deleted.');
    }
}