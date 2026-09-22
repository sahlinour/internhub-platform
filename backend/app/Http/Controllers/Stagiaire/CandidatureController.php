<?php

namespace App\Http\Controllers\Stagiaire;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Offredestage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CandidatureController extends Controller
{
    /**
     * List all applications submitted by the logged-in Stagiaire.
     */
    public function index(Request $request): Response
    {
        $stagiaire = Auth::user()->stagiaire;
        $sort = $request->get('sort', 'recently_updated');
        $query = Candidature::where(
            'idUtilisateur_Stagiaire',
            $stagiaire->user_id
        );

        switch ($sort) {
            case 'recently_applied':
                $query->orderBy('date_postulation', 'desc');
                break;
            case 'company_asc':
                $query
                    ->join(
                        'offredestages',
                        'candidatures.id_Offre_De_Stage',
                        '=',
                        'offredestages.id'
                    )
                    ->join(
                        'entreprises',
                        'offredestages.idUtilisateur_Entreprise',
                        '=',
                        'entreprises.user_id'
                    )
                    ->join(
                        'users',
                        'entreprises.user_id',
                        '=',
                        'users.id'
                    )
                    ->select('candidatures.*')
                    ->orderBy('users.nom_complet', 'asc');
                break;
            case 'status':
                $query->orderBy('statut', 'asc');
                break;
            case 'deadline':
                $query
                    ->join(
                        'offredestages',
                        'candidatures.id_Offre_De_Stage',
                        '=',
                        'offredestages.id'
                    )
                    ->select('candidatures.*')
                    ->orderBy('offredestages.date_limite', 'asc');
                break;
            case 'recently_updated':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        $candidatures = $query
            ->with([
                'offreDeStage.entreprise.user.ville',
            ])
            ->paginate(10)
            ->withQueryString();

        $statsQuery = Candidature::where(
            'idUtilisateur_Stagiaire',
            $stagiaire->user_id
        );
        $stats = [
            'applied' => (clone $statsQuery)->count(),
            'under_review' => (clone $statsQuery)
                ->where('statut', 'en_cours_examen')
                ->count(),
            'interview' => 0,
            'offer' => (clone $statsQuery)
                ->where('statut', 'acceptee')
                ->count(),
            'rejected' => (clone $statsQuery)
                ->where('statut', 'refusee')
                ->count(),
        ];

        return Inertia::render('Stagiaire/Candidatures/Index', [
            'candidatures' => $candidatures,
            'stats' => $stats,
            'sortBy' => $sort,
        ]);
    }

    /**
     * Display the internship application form.
     */
    public function create($offreId): Response
    {
        $offre = Offredestage::where('statut', 'ouverte')
            ->with([
                'entreprise.user',
                'entreprise.user.ville',
            ])
            ->findOrFail($offreId);

        $user = Auth::user()->load([
            'stagiaire',
            'ville',
        ]);

        return Inertia::render('Stagiaire/Offres/ApplyInternship', [
            'offre' => $offre,
            'stagiaire' => $user,
        ]);
    }

    /**
     * Submit a new application for a specific offer.
     */
    public function store(Request $request, $offreId): RedirectResponse
    {
        $request->validate([
            'lettre_de_motivation' => 'nullable|string|max:2000',
            'cv'                   => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'piece_jointe'         => 'nullable|file|mimes:pdf,zip,rar|max:10240',
        ]);

        $offre = Offredestage::findOrFail($offreId);
        $stagiaire = Auth::user()->stagiaire;
        $exists = Candidature::where(
                'idUtilisateur_Stagiaire',
                $stagiaire->user_id
            )
            ->where(
                'id_Offre_De_Stage',
                $offre->id
            )
            ->exists();
        if ($exists) {
            return back()->with(
                'error',
                'You have already applied to this offer.'
            );
        }

        $cvUrl = $stagiaire->cv_url;
        if ($request->hasFile('cv')) {
            $cvUrl = $request
                ->file('cv')
                ->store('candidatures/cvs', 'public');
        }
        $pieceJointeUrl = null;
        if ($request->hasFile('piece_jointe')) {
            $pieceJointeUrl = $request
                ->file('piece_jointe')
                ->store('candidatures/attachments', 'public');
        }
        $candidature = Candidature::create([
            'statut'                  => 'en_attente',
            'date_postulation'        => now(),
            'lettre_de_motivation'    => $request->lettre_de_motivation,
            'piece_jointe'            => $pieceJointeUrl,
            'cv_url'                  => $cvUrl,
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage'       => $offre->id,
        ]);

        return redirect()->route(
            'stagiaire.candidatures.show',
            $candidature->id
        );
    }

    /**
     * Display a specific application submitted by the logged-in Stagiaire.
     */
    public function show($id): Response
    {
        $stagiaire = Auth::user()->stagiaire;
        $candidature = Candidature::where('id', $id)
            ->where(
                'idUtilisateur_Stagiaire',
                $stagiaire->user_id
            )
            ->with([
                'offreDeStage.entreprise.user.ville',
            ])
            ->firstOrFail();

        return Inertia::render('Stagiaire/Candidatures/Show', [
            'candidature' => $candidature,
        ]);
    }

    /**
     * Cancel/Withdraw an application.
     */
    public function destroy($id): RedirectResponse
    {
        $stagiaire = Auth::user()->stagiaire;
        $candidature = Candidature::where('id', $id)
            ->where(
                'idUtilisateur_Stagiaire',
                $stagiaire->user_id
            )
            ->firstOrFail();

        $candidature->delete();
        return back()->with(
            'message',
            'Application withdrawn successfully.'
        );
    }
}
