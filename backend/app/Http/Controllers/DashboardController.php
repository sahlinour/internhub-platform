<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
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
            'Admin' => self::adminView(),
            'Entreprise' => self::entrepriseView($user->id),
            'Encadrant' => self::encadrantView($user->id),
            'Stagiaire' => self::stagiaireView($user->id),
            default => abort(403, 'Rôle non autorisé.'),
        };
    }

    /**
     * Build static metrics for Admin.
     */
    public static function adminView(): Response
    {
        $stats = [
            'total_users' => User::count(),
            'users_by_role' => User::select(
                'role',
                DB::raw('count(*) as total')
            )
                ->groupBy('role')
                ->pluck('total', 'role'),

            'total_offres' => OffreDeStage::count(),
            'total_stages' => Stage::count(),
            'total_documents' => Document::count(),
            'total_taches' => Tache::count(),

            'recent_users' => User::latest()
                ->take(5)
                ->get([
                    'id',
                    'nom_complet',
                    'email',
                    'role',
                ]),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }

    /**
     * Build metrics for Entreprise.
     */
    public static function entrepriseView(int $entrepriseId): Response
    {
        $offresIds = OffreDeStage::where(
            'idUtilisateur_Entreprise',
            $entrepriseId
        )->pluck('id');

        $openOffers = OffreDeStage::where(
            'idUtilisateur_Entreprise',
            $entrepriseId
        )
            ->where('statut', 'active')
            ->count();

        $applicants = Candidature::whereIn(
            'id_Offre_De_Stage',
            $offresIds
        )->count();

        $accepted = Candidature::whereIn(
            'id_Offre_De_Stage',
            $offresIds
        )
            ->where('statut', 'acceptee')
            ->count();

        $activeInterns = Stage::where(
            'statut',
            'en_cours'
        )
            ->whereHas(
                'candidature',
                function ($q) use ($offresIds) {
                    $q->whereIn(
                        'id_Offre_De_Stage',
                        $offresIds
                    );
                }
            )
            ->count();

        $recentApplicants = Candidature::whereIn(
            'id_Offre_De_Stage',
            $offresIds
        )
            ->with([
                'stagiaire.user',
                'offreDeStage',
            ])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($candidature) {
                $name =
                    $candidature->stagiaire?->user?->nom_complet
                    ?? 'Student';

                $initials = collect(
                    preg_split('/\s+/', trim($name))
                )
                    ->filter()
                    ->take(2)
                    ->map(
                        fn ($word) => strtoupper(substr($word, 0, 1))
                    )
                    ->implode('');

                return [
                    'id' => $candidature->id,
                    'name' => $name,
                    'initials' => $initials,
                    'offer' =>
                        $candidature->offreDeStage?->titre
                        ?? 'Internship',

                    'status' => match ($candidature->statut) {
                        'en_attente' => 'Pending',
                        'acceptee' => 'Accepted',
                        'refusee' => 'Rejected',
                        default => $candidature->statut,
                    },
                ];
            });

        return Inertia::render(
            'Entreprise/Dashboard',
            [
                'stats' => [
                    'open_offers' => $openOffers,
                    'applicants' => $applicants,
                    'accepted' => $accepted,
                    'active_interns' => $activeInterns,
                ],
                'recentApplicants' => $recentApplicants,
                'upcomingInterviews' => [],
            ]
        );
    }

    /**
     * Build metrics for Encadrant.
     */
    public static function encadrantView(int $encadrantId): Response
    {
        $stats = [
            'total_stages' => Stage::where(
                'idUtilisateur_Encadrant',
                $encadrantId
            )->count(),

            'taches_totales' => Tache::where(
                'idUtilisateur_Encadrant',
                $encadrantId
            )->count(),

            'taches_a_faire' => Tache::where(
                'idUtilisateur_Encadrant',
                $encadrantId
            )
                ->where('statut', 'À faire')
                ->count(),

            'documents_a_valider' => Document::where(
                'idUtilisateur_Encadrant',
                $encadrantId
            )
                ->where('statut', 'En attente')
                ->count(),

            'recent_documents' => Document::where(
                'idUtilisateur_Encadrant',
                $encadrantId
            )
                ->with('stage.candidature.stagiaire.user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return Inertia::render('Encadrant/Dashboard', [
            'stats' => $stats,
        ]);
    }

    /**
     * Build metrics for Stagiaire.
     */
    public static function stagiaireView(int $userId): Response
    {
        $user = User::findOrFail($userId);

        $stagiaire = \App\Models\Stagiaire::where(
            'user_id',
            $userId
        )->first();

        $profileFields = [
            'Full name' => !empty($user->nom_complet),
            'Email' => !empty($user->email),
            'Phone number' => !empty($user->telephone),
            'Profile photo' => !empty($user->photo),
            'University' => !empty($stagiaire?->universite),
            'Field of study' => !empty($stagiaire?->filiere),
            'Education level' => !empty($stagiaire?->niveau),
            'Date of birth' => !empty($stagiaire?->date_naissance),
            'CV' => !empty($stagiaire?->cv_url),
            'LinkedIn' => !empty($stagiaire?->linkedin_url),
            'Portfolio' => !empty($stagiaire?->portfolio_url),
        ];

        $completedProfileFields = collect($profileFields)
            ->filter()
            ->count();

        $totalProfileFields = count($profileFields);

        $profileCompletion = $totalProfileFields > 0
            ? (int) round(
                ($completedProfileFields / $totalProfileFields) * 100
            )
            : 0;

        $profileItems = collect($profileFields)
            ->map(
                fn ($completed, $label) => [
                    'label' => $label,
                    'completed' => $completed,
                ]
            )
            ->values()
            ->all();

        $applications = Candidature::with([
            'offreDeStage.entreprise.user',
        ])
            ->where(
                'idUtilisateur_Stagiaire',
                $userId
            )
            ->latest('date_postulation')
            ->take(5)
            ->get();

        $applicationsCount = Candidature::where(
            'idUtilisateur_Stagiaire',
            $userId
        )->count();

        $activeStage = Stage::whereHas(
            'candidature',
            fn ($query) => $query->where(
                'idUtilisateur_Stagiaire',
                $userId
            )
        )
            ->latest()
            ->first();

        $tasksCount = 0;
        $documentsCount = 0;

        if ($activeStage) {
            $tasksCount = Tache::where(
                'id_Stage',
                $activeStage->id
            )->count();

            $documentsCount = Document::where(
                'id_Stage',
                $activeStage->id
            )->count();
        }

        $recommendedOffers = OffreDeStage::with([
            'entreprise.user.ville',
        ])
            ->whereIn(
                'statut',
                [
                    'Ouverte',
                    'ouverte',
                ]
            )
            ->latest()
            ->take(4)
            ->get();

        $stats = [
            'has_stage' => (bool) $activeStage,

            'stage' => $activeStage
                ? $activeStage->load([
                    'candidature.offreDeStage.entreprise.user',
                    'encadrant.user',
                ])
                : null,

            'taches_count' => $tasksCount,
            'docs_count' => $documentsCount,

            'applications_count' => $applicationsCount,
            'applications' => $applications,
            'recommended_offers' => $recommendedOffers,

            'notifications' => [],

            'profile_completion' => $profileCompletion,
            'profile_items' => $profileItems,
        ];

        return Inertia::render(
            'Stagiaire/Dashboard',
            [
                'user' => $user->only([
                    'id',
                    'nom_complet',
                    'email',
                    'telephone',
                    'photo',
                ]),
                'stats' => $stats,
            ]
        );
    }
}
