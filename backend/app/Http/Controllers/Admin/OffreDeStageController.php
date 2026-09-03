<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Offredestage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OffreDeStageController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Offredestage::with([
            'entreprise.user',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $offres = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Offres/Index', [
            'offres' => $offres,
            'filters' => [
                'search' => $request->search,
                'statut' => $request->statut,
            ],
        ]);
    }

    public function create(): Response
    {
        $entreprises = Entreprise::with('user')
            ->orderBy('user_id')
            ->get();

        return Inertia::render('Admin/Offres/Create', [
            'entreprises' => $entreprises,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duree' => ['required', 'string', 'max:255'],
            'date_limite' => ['nullable', 'date'],
            'statut' => ['required', 'in:active,inactive,closed'],
            'idUtilisateur_Entreprise' => [
                'required',
                'exists:entreprises,user_id',
            ],
        ]);

        $offre = Offredestage::create($validated);

        return redirect()
            ->route('admin.offres.show', $offre->id)
            ->with('success', 'Internship offer created successfully.');
    }

    public function show($id): Response
    {
        $offre = Offredestage::with([
            'entreprise.user',
        ])->findOrFail($id);

        return Inertia::render('Admin/Offres/Show', [
            'offre' => $offre,
        ]);
    }

    public function edit($id): Response
    {
        $offre = Offredestage::with([
            'entreprise.user',
        ])->findOrFail($id);

        $entreprises = Entreprise::with('user')
            ->orderBy('user_id')
            ->get();

        return Inertia::render('Admin/Offres/Edit', [
            'offre' => $offre,
            'entreprises' => $entreprises,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $offre = Offredestage::findOrFail($id);

        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duree' => ['required', 'string', 'max:255'],
            'date_limite' => ['nullable', 'date'],
            'statut' => ['required', 'in:active,inactive,closed'],
            'idUtilisateur_Entreprise' => [
                'required',
                'exists:entreprises,user_id',
            ],
        ]);

        $offre->update($validated);

        return redirect()
            ->route('admin.offres.show', $offre->id)
            ->with('success', 'Internship offer updated successfully.');
    }

    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => ['required', 'in:active,inactive,closed'],
        ]);

        $offre = Offredestage::findOrFail($id);

        $offre->update([
            'statut' => $validated['statut'],
        ]);

        return back()->with(
            'success',
            'Internship offer status updated successfully.'
        );
    }

    public function destroy($id): RedirectResponse
    {
        $offre = Offredestage::findOrFail($id);

        $offre->delete();

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Internship offer deleted successfully.');
    }
}
