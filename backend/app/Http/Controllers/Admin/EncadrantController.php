<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use App\Models\Entreprise;
use App\Models\Ville;
use Inertia\Response;

class EncadrantController extends Controller
{
   public function index(Request $request)
{
    $query = Encadrant::with([
        'user.ville',
        'entreprise.user',
    ])
    ->withCount('stages');

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

    $encadrants = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('Admin/Encadrants/Index', [
        'encadrants' => $encadrants,
        'filters' => $request->only(['search', 'etat']),
    ]);
}

    public function show($id)
    {
        $user = User::where('role', 'Encadrant')
            ->with(['encadrant.entreprise.user', 'ville'])
            ->findOrFail($id);

        return Inertia::render('Admin/Encadrants/Show', [
            'encadrant' => $user,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'etat' => 'required|in:pending,active,block',
        ]);

        $user = User::where('role', 'Encadrant')->findOrFail($id);
        $user->update(['etat' => $request->etat]);

        return back()->with('message', "Status of the supervisor updated successfully.");
    }

    /**
     * Admin force resets Encadrant password (no current_password required).
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = User::where('role', 'Encadrant')->findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('message', "The password of the supervisor {$user->nom_complet} has been reset.");
    }

    public function destroy($id)
    {
        $user = User::where('role', 'Encadrant')->findOrFail($id);

        Encadrant::where('user_id', $user->id)->delete();
        $user->delete();

        return back()->with('message', 'Supervisor removed from the system.');
    }
    public function create(): Response
{
    $entreprises = Entreprise::with('user')
        ->orderBy('user_id')
        ->get();

    $villes = Ville::orderBy('nom')
        ->get([
            'id',
            'nom',
        ]);

    return Inertia::render('Admin/Encadrants/Create', [
        'entreprises' => $entreprises,
        'villes' => $villes,
    ]);
}
public function store(Request $request)
{
    $validated = $request->validate([
        'nom_complet' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'telephone' => 'nullable|string|max:30',
        'ville_id' => 'nullable|exists:villes,id',

        'password' => 'required|string|min:8|confirmed',

        'poste' => 'nullable|string|max:255',
        'specialite' => 'nullable|string|max:255',
        'departement' => 'nullable|string|max:255',

        'entreprise_id' => 'required|exists:entreprises,user_id',
    ]);

    DB::transaction(function () use ($validated) {
        $user = User::create([
            'nom_complet' => $validated['nom_complet'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'ville_id' => $validated['ville_id'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'Encadrant',
            'etat' => 'active',
        ]);

        Encadrant::create([
            'user_id' => $user->id,
            'entreprise_id' => $validated['entreprise_id'],
            'poste' => $validated['poste'] ?? null,
            'specialite' => $validated['specialite'] ?? null,
            'departement' => $validated['departement'] ?? null,
        ]);
    });

    return redirect()
        ->route('admin.encadrants.index')
        ->with('message', 'Supervisor created successfully.');
}
public function edit($id): Response
{
    $user = User::where('role', 'Encadrant')
        ->with([
            'encadrant.entreprise.user',
            'ville',
        ])
        ->findOrFail($id);

    $entreprises = Entreprise::with('user')
        ->orderBy('user_id')
        ->get();

    $villes = Ville::orderBy('nom')
        ->get([
            'id',
            'nom',
        ]);

    return Inertia::render('Admin/Encadrants/Edit', [
        'encadrant' => $user,
        'entreprises' => $entreprises,
        'villes' => $villes,
    ]);
}
public function update(Request $request, $id)
{
    $user = User::where('role', 'Encadrant')
        ->findOrFail($id);

    $validated = $request->validate([
        'nom_complet' => 'required|string|max:255',

        'email' => 'required|email|max:255|unique:users,email,' . $user->id,

        'telephone' => 'nullable|string|max:30',

        'ville_id' => 'nullable|exists:villes,id',

        'etat' => 'required|in:pending,active,block',

        'poste' => 'nullable|string|max:255',

        'specialite' => 'nullable|string|max:255',

        'departement' => 'nullable|string|max:255',

        'entreprise_id' => 'nullable|exists:entreprises,user_id',
    ]);

    DB::transaction(function () use ($validated, $user) {

        $user->update([
            'nom_complet' => $validated['nom_complet'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'ville_id' => $validated['ville_id'] ?? null,
            'etat' => $validated['etat'],
        ]);

        Encadrant::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'entreprise_id' => $validated['entreprise_id'] ?? null,
                'poste' => $validated['poste'] ?? null,
                'specialite' => $validated['specialite'] ?? null,
                'departement' => $validated['departement'] ?? null,
            ]
        );
    });

    return redirect()
        ->route('admin.encadrants.index')
        ->with(
            'message',
            'Supervisor updated successfully.'
        );
}
}
