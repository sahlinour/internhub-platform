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
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EntrepriseController extends Controller
{
    /**
     * Display company settings.
     */
    public function show(): Response
    {
        $user = User::with([
            'entreprise',
            'ville',
        ])->findOrFail(Auth::id());

        $villes = Ville::select('id', 'nom')
            ->orderBy('nom')
            ->get();

        return Inertia::render(
            'Entreprise/Profile/Show',
            [
                'entreprise' => $user,
                'villes' => $villes,
            ]
        );
    }

    /**
     * Update company profile information.
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
                'unique:users,email,' . $user->id,
            ],

            'telephone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'ville_id' => [
                'required',
                'exists:villes,id',
            ],

            'secteur' => [
                'required',
                'string',
                'max:255',
            ],

            'adresse' => [
                'required',
                'string',
                'max:255',
            ],

            'site_web' => [
                'nullable',
                'url',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Profile photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')->delete(
                    $user->photo
                );
            }

            $photoPath = $request
                ->file('photo')
                ->store(
                    'profiles/entreprises',
                    'public'
                );

            $user->photo = $photoPath;
        }

        /*
        |--------------------------------------------------------------------------
        | User information
        |--------------------------------------------------------------------------
        */

        $user->nom_complet = $validated['nom_complet'];
        $user->email = $validated['email'];
        $user->telephone = $validated['telephone'] ?? null;
        $user->ville_id = $validated['ville_id'];

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | Company information
        |--------------------------------------------------------------------------
        */

        Entreprise::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'secteur' => $validated['secteur'],
                'adresse' => $validated['adresse'],
                'site_web' => $validated['site_web'] ?? null,
                'description' => $validated['description'] ?? null,
            ]
        );

        return back()->with(
            'message',
            'Company profile updated successfully.'
        );
    }

    /**
     * Update company account password.
     */
    public function updatePassword(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                Password::defaults(),
                'confirmed',
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make(
                $validated['password']
            ),
        ]);

        return back()->with(
            'message',
            'Your password has been updated successfully.'
        );
    }

    /**
     * Delete company account.
     */
    public function destroy(
        Request $request
    ): RedirectResponse {
        $request->validate([
            'password' => [
                'required',
                'string',
            ],
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Verify password
        |--------------------------------------------------------------------------
        */

        if (!Hash::check(
            $request->password,
            $user->password
        )) {
            return back()->withErrors([
                'password' =>
                    'The provided password is incorrect.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete profile photo
        |--------------------------------------------------------------------------
        */

        if ($user->photo) {
            Storage::disk('public')->delete(
                $user->photo
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Logout before deleting account
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(
            'message',
            'Your enterprise account has been deleted.'
        );
    }
}
