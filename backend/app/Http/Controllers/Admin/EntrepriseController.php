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
use Inertia\Inertia;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of all companies with pagination and search filter.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'entreprise')
            ->with(['entreprise', 'ville']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom_complet', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by state if provided in query parameters
        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        $entreprises = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Entreprises/Index', [
            'entreprises' => $entreprises,
            'filters'     => $request->only(['search', 'etat']),
        ]);
    }

    /**
     * Show the detailed information of a specific company.
     */
    public function show($id)
    {
        $user = User::where('role', 'entreprise')
            ->with(['entreprise', 'ville', 'entreprise.encadrants.user'])
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
        $user = User::where('role', 'entreprise')
            ->with(['entreprise', 'ville'])
            ->findOrFail($id);

        $villes = Ville::select('id', 'nom')->get();

        return Inertia::render('Admin/Entreprises/Edit', [
            'entreprise' => $user,
            'villes'     => $villes,
        ]);
    }

    /**
     * Update an existing company profile and user account.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'entreprise')->findOrFail($id);

        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone'   => 'nullable|string|max:20',
            'ville_id'    => 'required|exists:villes,id',
            'etat'        => 'required|in:pending,active,block',
            'secteur'     => 'required|string|max:255',
            'adresse'     => 'required|string|max:255',
            'site_web'    => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles/entreprises', 'public');
        }

        $user->update([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'ville_id'    => $request->ville_id,
            'etat'        => $request->etat,
        ]);

        Entreprise::updateOrCreate(
            ['user_id' => $user->id],
            [
                'secteur'     => $request->secteur,
                'adresse'     => $request->adresse,
                'site_web'    => $request->site_web,
                'description' => $request->description,
            ]
        );

        return redirect()->route('admin.entreprises.index')
            ->with('message', 'Business updated successfully.');
    }

    /**
     * Admin force resets an Entreprise user password (no current password required).
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = User::where('role', 'entreprise')->findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('message', "The password of the company {$user->nom_complet} has been reset.");
    }

    /**
     * Update only the state ('pending', 'active', 'block') of a company user.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'etat' => 'required|in:pending,active,block',
        ]);

        $user = User::where('role', 'entreprise')->findOrFail($id);
        $user->update(['etat' => $request->etat]);

        return back()->with('message', "The status of the company has been changed to '{$request->etat}'.");
    }

    /**
     * Delete a company user account and its related data.
     */
    public function destroy($id)
    {
        $user = User::where('role', 'entreprise')->findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.entreprises.index')
            ->with('message', 'Company removed from the system.');
    }
}