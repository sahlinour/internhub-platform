<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class EncadrantController extends Controller
{
    /**
     * Display listing of encadrants belonging to this entreprise.
     */
    public function index()
    {
        $entrepriseId = Auth::id();

        $encadrants = User::where('role', 'encadrant')
            ->whereHas('encadrant', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->with(['encadrant', 'ville'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Entreprise/Encadrants/Index', [
            'encadrants' => $encadrants,
        ]);
    }

    /**
     * Store a new Encadrant under current Entreprise.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email',
            'password'    => ['required', Password::defaults()],
            'telephone'   => 'nullable|string|max:20',
            'poste'       => 'required|string|max:255',
            'specialite'  => 'nullable|string|max:255',
            'departement' => 'nullable|string|max:255',
            'ville_id'    => 'required|exists:villes,id',
        ]);

        $user = User::create([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'telephone'   => $request->telephone,
            'role'        => 'encadrant',
            'etat'        => 'active',
            'ville_id'    => $request->ville_id,
        ]);

        Encadrant::create([
            'user_id'       => $user->id,
            'poste'         => $request->poste,
            'specialite'    => $request->specialite,
            'departement'   => $request->departement,
            'entreprise_id' => Auth::id(),
        ]);

        return back()->with('message', 'Framework successfully created.');
    }

    /**
     * Update Encadrant information (poste, department, phone, etc.).
     */
    public function update(Request $request, $id)
    {
        $entrepriseId = Auth::id();

        // Verify the encadrant actually belongs to this entreprise
        $user = User::where('role', 'encadrant')
            ->whereHas('encadrant', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->findOrFail($id);

        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone'   => 'nullable|string|max:20',
            'poste'       => 'required|string|max:255',
            'specialite'  => 'nullable|string|max:255',
            'departement' => 'nullable|string|max:255',
            'ville_id'    => 'required|exists:villes,id',
        ]);

        $user->update([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'ville_id'    => $request->ville_id,
        ]);

        $user->encadrant()->update([
            'poste'       => $request->poste,
            'specialite'  => $request->specialite,
            'departement' => $request->departement,
        ]);

        return back()->with('message', "Framework information updated.");
    }

    /**
     * Entreprise updates Encadrant password directly (NO old password required).
     */
    public function resetPassword(Request $request, $id)
    {
        $entrepriseId = Auth::id();

        $user = User::where('role', 'encadrant')
            ->whereHas('encadrant', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->findOrFail($id);

        $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('message', "The password for framework {$user->nom_complet} has been updated.");
    }

    /**
     * Entreprise deletes their encadrant.
     */
    public function destroy($id)
    {
        $entrepriseId = Auth::id();

        $user = User::where('role', 'encadrant')
            ->whereHas('encadrant', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->findOrFail($id);

        Encadrant::where('user_id', $user->id)->delete();
        $user->delete();

        return back()->with('message', 'Framework removed with success.');
    }
}