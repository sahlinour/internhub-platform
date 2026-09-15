<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class EncadrantController extends Controller
{
    /**
     * Display company supervisors.
     */
    public function index(): Response
    {
        $entrepriseId = Auth::id();

        $encadrants = User::where('role', 'Encadrant')
            ->whereHas('encadrant', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->with([
                'encadrant',
                'ville',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render(
            'Entreprise/Encadrants/Index',
            [
                'encadrants' => $encadrants,
            ]
        );
    }

    /**
     * Display the create supervisor page.
     */
    public function create(): Response
    {
        $villes = Ville::select('id', 'nom')
            ->orderBy('nom')
            ->get();

        return Inertia::render(
            'Entreprise/Encadrants/Create',
            [
                'villes' => $villes,
            ]
        );
    }

    /**
     * Create a new company supervisor.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom_complet' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                Password::defaults(),
            ],

            'telephone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'poste' => [
                'required',
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

            'ville_id' => [
                'required',
                'exists:villes,id',
            ],
        ]);

        $user = User::create([
            'nom_complet' => $request->nom_complet,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
            'role' => 'Encadrant',
            'etat' => 'active',
            'ville_id' => $request->ville_id,
        ]);

        Encadrant::create([
            'user_id' => $user->id,
            'poste' => $request->poste,
            'specialite' => $request->specialite,
            'departement' => $request->departement,
            'entreprise_id' => Auth::id(),
        ]);

        return redirect()
            ->route('entreprise.encadrants.index')
            ->with(
                'message',
                'Supervisor successfully created.'
            );
    }

    /**
     * Update supervisor information.
     */
    public function update(
        Request $request,
        $id
    ): RedirectResponse {
        $entrepriseId = Auth::id();

        $user = User::where('role', 'Encadrant')
            ->whereHas(
                'encadrant',
                function ($q) use ($entrepriseId) {
                    $q->where(
                        'entreprise_id',
                        $entrepriseId
                    );
                }
            )
            ->findOrFail($id);

        $request->validate([
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

            'poste' => [
                'required',
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

            'ville_id' => [
                'required',
                'exists:villes,id',
            ],
        ]);

        $user->update([
            'nom_complet' => $request->nom_complet,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'ville_id' => $request->ville_id,
        ]);

        $user->encadrant()->update([
            'poste' => $request->poste,
            'specialite' => $request->specialite,
            'departement' => $request->departement,
        ]);

        return back()->with(
            'message',
            'Supervisor information updated.'
        );
    }

    /**
     * Reset supervisor password.
     */
    public function resetPassword(
        Request $request,
        $id
    ): RedirectResponse {
        $entrepriseId = Auth::id();

        $user = User::where('role', 'Encadrant')
            ->whereHas(
                'encadrant',
                function ($q) use ($entrepriseId) {
                    $q->where(
                        'entreprise_id',
                        $entrepriseId
                    );
                }
            )
            ->findOrFail($id);

        $request->validate([
            'password' => [
                'required',
                Password::defaults(),
                'confirmed',
            ],
        ]);

        $user->update([
            'password' => Hash::make(
                $request->password
            ),
        ]);

        return back()->with(
            'message',
            'Supervisor password updated.'
        );
    }

    /**
     * Delete a company supervisor.
     */
    public function destroy($id): RedirectResponse
    {
        $entrepriseId = Auth::id();

        $user = User::where('role', 'Encadrant')
            ->whereHas(
                'encadrant',
                function ($q) use ($entrepriseId) {
                    $q->where(
                        'entreprise_id',
                        $entrepriseId
                    );
                }
            )
            ->findOrFail($id);

        Encadrant::where(
            'user_id',
            $user->id
        )->delete();

        $user->delete();

        return back()->with(
            'message',
            'Supervisor successfully removed.'
        );
    }
}
