<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AdminProfileController extends Controller
{
    public function show()
    {
          $user = User::with(['ville'])->findOrFail(Auth::id());
        return Inertia::render('Admin/Profile/Show', [
            'admin' => $user,
        ]);
    }

    public function edit()
    {
        $user = User::with(['ville'])->findOrFail(Auth::id());
        $villes = Ville::select('id', 'nom')->get();

        return Inertia::render('Admin/Profile/Edit', [
            'admin'  => $user,
            'villes' => $villes,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone'   => 'nullable|string|max:20',
            'ville_id'    => 'required|exists:villes,id',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles/admins', 'public');
        }

        $user->update([
            'nom_complet' => $request->nom_complet,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'ville_id'    => $request->ville_id,
        ]);

        // Admin::firstOrCreate(['idUtilisateur' => $user->id]);

        return back()->with('message', 'Administrator profile updated.');
    }

    /**
     * Update the authenticated Admin password.
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

        return back()->with('message', 'Password updated successfully.');
    }
}
