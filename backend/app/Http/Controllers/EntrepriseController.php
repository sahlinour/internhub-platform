<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    /**
     * Liste des entreprises
     */
    public function index(Request $request)
    {
        $entreprises = Entreprise::query()
            ->with(['user', 'encadrants'])
            ->when($request->search, function ($query, $search) {
                $query->where('secteur', 'ILIKE', "%{$search}%")
                    ->orWhere('adresse', 'ILIKE', "%{$search}%")
                    ->orWhere('site_web', 'ILIKE', "%{$search}%");
            })
            ->paginate($request->per_page ?? 10);

        return response()->json($entreprises);
    }

    /**
     * Créer une entreprise
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:entreprises,user_id',

            'secteur' => 'nullable|string|max:255',

            'adresse' => 'nullable|string|max:255',

            'site_web' => 'nullable|string|max:255',

            'description' => 'nullable|string',
        ]);

        $entreprise = Entreprise::create($validated);

        $entreprise->load('user');

        return response()->json([
            'message' => 'Entreprise créée avec succès',
            'data' => $entreprise,
        ], 201);
    }

    /**
     * Consulter une entreprise
     */
    public function show(Entreprise $entreprise)
    {
        $entreprise->load([
            'user',
            'encadrants',
        ]);

        return response()->json([
            'data' => $entreprise,
        ]);
    }

    /**
     * Modifier une entreprise
     */
    public function update(Request $request, Entreprise $entreprise)
    {
        $validated = $request->validate([
            'secteur' => 'sometimes|nullable|string|max:255',

            'adresse' => 'sometimes|nullable|string|max:255',

            'site_web' => 'sometimes|nullable|string|max:255',

            'description' => 'sometimes|nullable|string',
        ]);

        $entreprise->update($validated);

        $entreprise->load('user');

        return response()->json([
            'message' => 'Entreprise modifiée avec succès',
            'data' => $entreprise,
        ]);
    }

    /**
     * Supprimer une entreprise
     */
    public function destroy(Entreprise $entreprise)
    {
        $entreprise->delete();

        return response()->json([
            'message' => 'Entreprise supprimée avec succès',
        ]);
    }
}