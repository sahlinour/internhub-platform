<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of all companies with pagination and search filter.
     */
public function index(Request $request)
{
    $query = Entreprise::with([
        'user.ville',
    ]);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->whereHas('user', function ($q) use ($search) {
            $q->where('nom_complet', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if ($request->filled('etat')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('etat', $request->etat);
        });
    }

    $entreprises = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('Admin/Entreprises/Index', [
        'entreprises' => $entreprises,
        'filters' => $request->only([
            'search',
            'etat',
        ]),
    ]);
}
    /**
     * Show the detailed information of a specific company.
     */
    public function show($id)
    {
        $user = User::where('role', 'Entreprise')
            ->with([
                'entreprise',
                'ville',
                'entreprise.encadrants.user',
            ])
            ->findOrFail($id);

        return Inertia::render('Admin/Entreprises/Show', [
            'entreprise' => $user,
        ]);
    }

    /**
     * Show the form for editing an existing company.
     */
    public function edit($id)
    {
        $user = User::where('role', 'Entreprise')
            ->with([
                'entreprise',
                'ville',
            ])
            ->findOrFail($id);

        $villes = Ville::select('id', 'nom')->get();

        return Inertia::render('Admin/Entreprises/Edit', [
            'entreprise' => $user,
            'villes' => $villes,
        ]);
    }

    /**
     * Update an existing company profile and user account.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'Entreprise')
            ->findOrFail($id);

        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'ville_id' => 'required|exists:villes,id',
            'etat' => 'required|in:pending,active,block',
            'secteur' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'site_web' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $userData = [
            'nom_complet' => $validated['nom_complet'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'ville_id' => $validated['ville_id'],
            'etat' => $validated['etat'],
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $userData['photo'] = $request
                ->file('photo')
                ->store('profiles/entreprises', 'public');
        }

        $user->update($userData);

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

        return redirect()
            ->route('admin.entreprises.index')
            ->with(
                'message',
                'Business updated successfully.'
            );
    }

    /**
     * Admin force resets an Entreprise user password.
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => [
                'required',
                Password::defaults(),
                'confirmed',
            ],
        ]);

        $user = User::where('role', 'Entreprise')
            ->findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with(
            'message',
            "The password of the company {$user->nom_complet} has been reset."
        );
    }

    /**
     * Update only the state of a company user.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'etat' => 'required|in:pending,active,block',
        ]);

        $user = User::where('role', 'Entreprise')
            ->findOrFail($id);

        $user->update([
            'etat' => $request->etat,
        ]);

        return back()->with(
            'message',
            "The status of the company has been changed to '{$request->etat}'."
        );
    }

    /**
     * Delete a company user account and related data.
     */
    public function destroy($id)
    {
        $user = User::where('role', 'Entreprise')
            ->findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()
            ->route('admin.entreprises.index')
            ->with(
                'message',
                'Company removed from the system.'
            );
    }

    /**
     * Show the company creation form.
     */
    public function create(): Response
    {
        $villes = Ville::orderBy('nom')->get([
            'id',
            'nom',
        ]);

        return Inertia::render('Admin/Entreprises/Create', [
            'villes' => $villes,
        ]);
    }

    /**
     * Create a new company.
     */
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

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'secteur' => [
                'nullable',
                'string',
                'max:255',
            ],

            'adresse' => [
                'nullable',
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

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request
                ->file('photo')
                ->store(
                    'profiles/entreprises',
                    'public'
                );
        }

        try {
            DB::transaction(function () use (
                $validated,
                $photoPath
            ) {
                $user = User::create([
                    'nom_complet' => $validated['nom_complet'],
                    'email' => $validated['email'],
                    'telephone' => $validated['telephone'] ?? null,
                    'ville_id' => $validated['ville_id'] ?? null,
                    'photo' => $photoPath,
                    'password' => Hash::make(
                        $validated['password']
                    ),

                    // Important: role value uses uppercase E
                    'role' => 'Entreprise',

                    'etat' => 'active',
                ]);

                Entreprise::create([
                    'user_id' => $user->id,
                    'secteur' => $validated['secteur'] ?? null,
                    'adresse' => $validated['adresse'] ?? null,
                    'site_web' => $validated['site_web'] ?? null,
                    'description' => $validated['description'] ?? null,
                ]);
            });
        } catch (\Throwable $e) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.entreprises.index')
            ->with(
                'message',
                'Company created successfully.'
            );
    }
}
