<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\OffreDeStage;
use App\Models\Stage;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Main route entry point.
     */
    public function __invoke(Request $request): Response
    {
        $user = Auth::user();

        return match ($user->role) {
            'Admin'      => self::adminView(),
            'Entreprise' => self::entrepriseView($user->id),
            'Encadrant'  => self::encadrantView($user->id),
            'Stagiaire'  => self::stagiaireView($user->id),
            default      => abort(403, 'Rôle non autorisé.'),
        };
    }

    // ==========================================
    // STATIC ROLE DATA BUILDERS
    // ==========================================

    /**
     * Build static metrics for Admin.
     */
    public static function adminView(): Response
    {
        $stats = [
            'total_users'     => User::count(),
            'users_by_role'   => User::select('role', DB::raw('count(*) as total'))
                                     ->groupBy('role')
                                     ->pluck('total', 'role'),
            'total_offres'    => OffreDeStage::count(),
            'total_stages'    => Stage::count(),
            'total_documents' => Document::count(),
            'total_taches'    => Tache::count(),
            'recent_users'    => User::latest()->take(5)->get(['id', 'nom_complet', 'email', 'role']),
        ];

        return Inertia::render('Admin/Dashboard', ['stats' => $stats]);
    }

    /**
     * Build static metrics for Entreprise.
     */
    public static function entrepriseView(int $entrepriseId): Response
    {
        $offresIds = OffreDeStage::where('idUtilisateur_Entreprise', $entrepriseId)->pluck('id');

        $stats = [
            'total_offres'     => $offresIds->count(),
            'offres_actives'   => OffreDeStage::where('idUtilisateur_Entreprise', $entrepriseId)->where('statut', 'Ouverte')->count(),
            'total_stages'     => Stage::whereHas('candidature', fn($q) => $q->whereIn('idOffreDeStage', $offresIds))->count(),
            'recent_offres'    => OffreDeStage::where('idUtilisateur_Entreprise', $entrepriseId)->latest()->take(5)->get(),
        ];

        return Inertia::render('Entreprise/Dashboard', ['stats' => $stats]);
    }

    /**
     * Build static metrics for Encadrant.
     */
    public static function encadrantView(int $encadrantId): Response
    {
        $stats = [
            'total_stages'        => Stage::where('idUtilisateur_Encadrant', $encadrantId)->count(),
            'taches_totales'      => Tache::where('idUtilisateur_Encadrant', $encadrantId)->count(),
            'taches_a_faire'      => Tache::where('idUtilisateur_Encadrant', $encadrantId)->where('statut', 'À faire')->count(),
            'documents_a_valider' => Document::where('idUtilisateur_Encadrant', $encadrantId)->where('statut', 'En attente')->count(),
            'recent_documents'    => Document::where('idUtilisateur_Encadrant', $encadrantId)->with('stage.candidature.stagiaire.user')->latest()->take(5)->get(),
        ];

        return Inertia::render('Encadrant/Dashboard', ['stats' => $stats]);
    }

    /**
     * Build static metrics for Stagiaire.
     */
    public static function stagiaireView(int $stagiaireId): Response
    {
        $activeStage = Stage::whereHas('candidature', fn($q) => $q->where('idUtilisateur_Stagiaire', $stagiaireId))->first();

        $stats = [
            'has_stage'    => (bool) $activeStage,
            'stage'        => $activeStage ? $activeStage->load(['candidature.offreDeStage.entreprise.user', 'encadrant.user']) : null,
            'taches_count' => $activeStage ? Tache::where('id_Stage', $activeStage->id)->count() : 0,
            'docs_count'   => $activeStage ? Document::where('id_Stage', $activeStage->id)->count() : 0,
        ];

        return Inertia::render('Stagiaire/Dashboard', ['stats' => $stats]);
    }
}