<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
   
    public function edit(): Response
    {
        $user = Auth::user();

        $encadrant = Encadrant::where('user_id', $user->id)->first();

        return Inertia::render('Encadrant/Profile/Edit', [
            'user' => [
                'id' => $user->id,
                'nom_complet' => $user->nom_complet,
                'email' => $user->email,
                'telephone' => $user->telephone ?? null,
                'role' => $user->role,
            ],

            'encadrant' => $encadrant
                ? [
                    'user_id' => $encadrant->user_id,
                    'poste' => $encadrant->poste,
                    'specialite' => $encadrant->specialite,
                    'departement' => $encadrant->departement,
                    'entreprise_id' => $encadrant->entreprise_id,
                ]
                : null,
        ]);
    }

    /**
     * Update Encadrant profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom_complet' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'telephone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'poste' => [
                'nullable',
                'string',
                'max:255',
            ],

            'specialite' => [
                'nullable',
                'string',
                'max:255',
            ],

            'departement' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        // Update User
        $user->nom_complet = $validated['nom_complet'];
        $user->email = $validated['email'];
        $user->telephone = $validated['telephone'] ?? null;
        $user->save();

        // Update Encadrant
        $encadrant = Encadrant::where('user_id', $user->id)->first();

        if ($encadrant) {
            $encadrant->poste = $validated['poste'] ?? null;
            $encadrant->specialite = $validated['specialite'] ?? null;
            $encadrant->departement = $validated['departement'] ?? null;
            $encadrant->save();
        }

        return redirect()
            ->route('encadrant.profile.edit')
            ->with('message', 'Profile updated successfully.');
    }

    /**
     * Update Encadrant password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user = Auth::user();

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('encadrant.profile.edit')
            ->with('message', 'Password updated successfully.');
    }
}
