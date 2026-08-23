<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Ville;
use App\Models\Entreprise;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
{
    return Inertia::render('Auth/Register', [
        'villes' => Ville::select('id', 'nom')
            ->orderBy('nom')
            ->get(),
    ]);
}

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            'unique:' . User::class,
        ],

        'ville_id' => ['nullable', 'exists:villes,id'],

        'password' => [
            'required',
            'confirmed',
            Rules\Password::defaults(),
        ],

        'role' => [
            'required',
            'in:Stagiaire,Entreprise',
        ],

        // Company fields
        'secteur' => ['nullable', 'string', 'max:255'],
        'adresse' => ['nullable', 'string', 'max:255'],
        'site_web' => ['nullable', 'url', 'max:255'],
        'description' => ['nullable', 'string'],
    ]);

    $user = User::create([
        'nom_complet' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
        'ville_id' => $validated['ville_id'] ?? null,
    ]);

    if ($validated['role'] === 'Entreprise') {
        Entreprise::create([
            'user_id' => $user->id,
            'secteur' => $validated['secteur'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
            'site_web' => $validated['site_web'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
    }

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}
