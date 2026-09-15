<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class EncadrantController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'encadrant')
            ->with(['encadrant.entreprise.user', 'ville']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom_complet', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        $encadrants = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Encadrants/Index', [
            'encadrants' => $encadrants,
            'filters'    => $request->only(['search', 'etat']),
        ]);
    }

    public function show($id)
    {
        $user = User::where('role', 'encadrant')
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

        $user = User::where('role', 'encadrant')->findOrFail($id);
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

        $user = User::where('role', 'encadrant')->findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('message', "The password of the supervisor {$user->nom_complet} has been reset.");
    }

    public function destroy($id)
    {
        $user = User::where('role', 'encadrant')->findOrFail($id);

        Encadrant::where('user_id', $user->id)->delete();
        $user->delete();

        return back()->with('message', 'Supervisor removed from the system.');
    }
}