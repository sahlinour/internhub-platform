<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class StagiaireController extends Controller
{
    /**
     * Display all interns.
     */
    public function index(Request $request): Response
    {
        $query = Stagiaire::with([
            'user.ville',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nom_complet', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Account status filter
        if ($request->filled('etat')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('etat', $request->etat);
            });
        }

        $stagiaires = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Stagiaires/Index', [
            'stagiaires' => $stagiaires,
            'filters' => $request->only([
                'search',
                'etat',
            ]),
        ]);
    }

    /**
     * Show form for creating a new intern.
     */
    public function create(): Response
    {
        $villes = Ville::orderBy('nom')
            ->get([
                'id',
                'nom',
            ]);

        return Inertia::render('Admin/Stagiaires/Create', [
            'villes' => $villes,
        ]);
    }

    public function store(Request $request): RedirectResponse
{
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
            'unique:users,email',
        ],

        'telephone' => [
            'nullable',
            'string',
            'max:30',
        ],

        'ville_id' => [
            'nullable',
            'exists:villes,id',
        ],

        'universite' => [
            'nullable',
            'string',
            'max:255',
        ],

        'filiere' => [
            'nullable',
            'string',
            'max:255',
        ],

        'niveau' => [
            'nullable',
            'string',
            'max:255',
        ],

        'date_naissance' => [
            'nullable',
            'date',
        ],

        'statut_stage' => [
            'nullable',
            'in:recherche,en_attente,en_cours,termine,annule',
        ],

        'linkedin_url' => [
            'nullable',
            'url',
            'max:255',
        ],

        'portfolio_url' => [
            'nullable',
            'url',
            'max:255',
        ],

        'password' => [
            'required',
            'confirmed',
            Password::min(8),
        ],
    ]);

    DB::transaction(function () use ($validated) {

        $user = User::create([
            'nom_complet' => $validated['nom_complet'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'ville_id' => $validated['ville_id'] ?? null,

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => 'Stagiaire',
            'etat' => 'active',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,

            'universite' =>
                $validated['universite'] ?? null,

            'filiere' =>
                $validated['filiere'] ?? null,

            'niveau' =>
                $validated['niveau'] ?? null,

            'date_naissance' =>
                $validated['date_naissance'] ?? null,

            'statut_stage' =>
                $validated['statut_stage'] ?? 'recherche',

            'linkedin_url' =>
                $validated['linkedin_url'] ?? null,

            'portfolio_url' =>
                $validated['portfolio_url'] ?? null,
        ]);
    });

    return redirect()
        ->route('admin.stagiaires.index')
        ->with('success', 'Intern created successfully.');
}
    public function show($id): Response
    {
        $user = User::where('role', 'Stagiaire')
            ->with([
                'stagiaire',
                'ville',
            ])
            ->findOrFail($id);

        return Inertia::render('Admin/Stagiaires/Show', [
            'stagiaire' => $user,
        ]);
    }

    /**
     * Show form for editing an intern.
     */
    public function edit($id): Response
    {
        $user = User::where('role', 'Stagiaire')
            ->with([
                'stagiaire',
                'ville',
            ])
            ->findOrFail($id);

        $villes = Ville::orderBy('nom')
            ->get([
                'id',
                'nom',
            ]);

        return Inertia::render('Admin/Stagiaires/Edit', [
            'stagiaire' => $user,
            'villes' => $villes,
        ]);
    }

    /**
     * Update an intern.
     */
    public function update(
        Request $request,
        $id
    ): RedirectResponse {
        $user = User::where('role', 'Stagiaire')
            ->findOrFail($id);

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
                'max:30',
            ],

            'ville_id' => [
                'nullable',
                'exists:villes,id',
            ],

            'etat' => [
                'required',
                'in:pending,active,block',
            ],

            'universite' => [
                'nullable',
                'string',
                'max:255',
            ],

            'filiere' => [
                'nullable',
                'string',
                'max:255',
            ],

            'niveau' => [
                'nullable',
                'string',
                'max:255',
            ],

            'statut_stage' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        DB::transaction(function () use (
            $user,
            $validated
        ) {
            $user->update([
                'nom_complet' => $validated['nom_complet'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'] ?? null,
                'ville_id' => $validated['ville_id'] ?? null,
                'etat' => $validated['etat'],
            ]);

            Stagiaire::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'universite' =>
                        $validated['universite'] ?? null,

                    'filiere' =>
                        $validated['filiere'] ?? null,

                    'niveau' =>
                        $validated['niveau'] ?? null,

                    'statut_stage' =>
                        $validated['statut_stage'] ?? null,
                ]
            );
        });

        return redirect()
            ->route('admin.stagiaires.index')
            ->with(
                'message',
                'Intern updated successfully.'
            );
    }

    /**
     * Update only the account status.
     */
    public function updateStatus(
        Request $request,
        $id
    ): RedirectResponse {
        $validated = $request->validate([
            'etat' => [
                'required',
                'in:pending,active,block',
            ],
        ]);

        $user = User::where('role', 'Stagiaire')
            ->findOrFail($id);

        $user->update([
            'etat' => $validated['etat'],
        ]);

        return back()->with(
            'message',
            'Intern status updated successfully.'
        );
    }

    /**
     * Admin resets intern password.
     */
    public function resetPassword(
        Request $request,
        $id
    ): RedirectResponse {
        $request->validate([
            'password' => [
                'required',
                Password::defaults(),
                'confirmed',
            ],
        ]);

        $user = User::where('role', 'Stagiaire')
            ->findOrFail($id);

        $user->update([
            'password' => Hash::make(
                $request->password
            ),
        ]);

        return back()->with(
            'message',
            "The password of {$user->nom_complet} has been reset."
        );
    }

    /**
     * Delete an intern.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::where('role', 'Stagiaire')
            ->findOrFail($id);

        DB::transaction(function () use ($user) {
            Stagiaire::where(
                'user_id',
                $user->id
            )->delete();

            $user->delete();
        });

        return redirect()
            ->route('admin.stagiaires.index')
            ->with(
                'message',
                'Intern removed from the system.'
            );
    }
}
