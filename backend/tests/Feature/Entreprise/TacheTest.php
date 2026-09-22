<?php

namespace Tests\Feature\Entreprise;

use App\Models\Candidature;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TacheTest extends TestCase
{
    use RefreshDatabase;

    private function createEntreprise(): User
    {
        $user = User::factory()->create([
            'role' => 'Entreprise',
            'etat' => 'active',
        ]);

        Entreprise::create([
            'user_id' => $user->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tangier',
            'site_web' => 'https://example.com',
            'description' => 'Test company',
        ]);

        return $user;
    }

    private function createStagiaire(): User
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'etat' => 'active',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    private function createEncadrant(User $entreprise): User
    {
        $user = User::factory()->create([
            'role' => 'Encadrant',
            'etat' => 'active',
        ]);

        Encadrant::create([
            'user_id' => $user->id,
            'poste' => 'Développeur',
            'specialite' => 'Laravel',
            'departement' => 'IT',
            'entreprise_id' => $entreprise->id,
        ]);

        return $user;
    }

    private function createOffer(User $entreprise): Offredestage
    {
        return Offredestage::create([
            'titre' => 'Stage Laravel',
            'description' => 'Développement web avec Laravel',
            'duree' => '3 mois',
            'date_limite' => now()->addMonth()->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entreprise->id,
        ]);
    }

    private function createCandidature(
        User $stagiaire,
        Offredestage $offre
    ): Candidature {
        return Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite effectuer ce stage.',
            'piece_jointe' => null,
            'cv_url' => null,
            'idUtilisateur_Stagiaire' => $stagiaire->id,
            'id_Offre_De_Stage' => $offre->id,
        ]);
    }

    private function createStage(
        Candidature $candidature,
        User $encadrant
    ): Stage {
        return Stage::create([
            'sujet' => 'Développement de la plateforme InternHub',
            'date_debut' => now()->addDay()->toDateString(),
            'date_fin' => now()->addMonths(3)->toDateString(),
            'statut' => 'en_cours',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    private function createTache(
        Stage $stage,
        User $encadrant,
        string $titre = 'Développer le module de connexion',
        ?string $dateEcheance = null
    ): Tache {
        return Tache::create([
            'titre' => $titre,
            'description' => 'Développer et tester la fonctionnalité.',
            'priorite' => 'Moyenne',
            'date_creation' => now()->toDateString(),
            'date_echeance' => $dateEcheance ?? now()->addDays(7)->toDateString(),
            'date_fin_effective' => null,
            'statut' => 'a_faire',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_entreprise_can_view_tasks_of_its_internships(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);

        $candidature = $this->createCandidature(
            $stagiaire,
            $offre
        );

        $stage = $this->createStage(
            $candidature,
            $encadrant
        );

        $tache = $this->createTache(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where(
                        'taches.data.0.id',
                        $tache->id
                    )
            );
    }

    public function test_entreprise_gets_empty_tasks_list_when_no_tasks_exist(): void
    {
        $entreprise = $this->createEntreprise();

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 0)
            );
    }

    public function test_entreprise_only_sees_tasks_from_its_own_company(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($otherEntreprise);

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($otherEntreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1),
            $encadrant1
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2),
            $encadrant2
        );

        $tache1 = $this->createTache(
            $stage1,
            $encadrant1,
            'Company 1 Task'
        );

        $tache2 = $this->createTache(
            $stage2,
            $encadrant2,
            'Company 2 Task'
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where(
                        'taches.data.0.id',
                        $tache1->id
                    )
            );

        $this->assertNotEquals(
            $tache1->id,
            $tache2->id
        );
    }

    public function test_entreprise_can_filter_tasks_by_stage(): void
    {
        $entreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant = $this->createEncadrant($entreprise);

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($entreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1),
            $encadrant
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2),
            $encadrant
        );

        $tache1 = $this->createTache(
            $stage1,
            $encadrant,
            'Stage 1 Task'
        );

        $this->createTache(
            $stage2,
            $encadrant,
            'Stage 2 Task'
        );

        $response = $this->actingAs($entreprise)
            ->get(
                route(
                    'entreprise.taches.index',
                    ['stage_id' => $stage1->id]
                )
            );

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where(
                        'taches.data.0.id',
                        $tache1->id
                    )
                    ->where(
                        'filters.stage_id',
                        (string) $stage1->id
                    )
            );
    }

    public function test_stage_filter_does_not_return_tasks_from_other_stages(): void
    {
        $entreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant = $this->createEncadrant($entreprise);

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($entreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1),
            $encadrant
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2),
            $encadrant
        );

        $tache1 = $this->createTache(
            $stage1,
            $encadrant,
            'Stage 1 Task'
        );

        $tache2 = $this->createTache(
            $stage2,
            $encadrant,
            'Stage 2 Task'
        );

        $response = $this->actingAs($entreprise)
            ->get(
                route(
                    'entreprise.taches.index',
                    ['stage_id' => $stage2->id]
                )
            );

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where(
                        'taches.data.0.id',
                        $tache2->id
                    )
            );

        $this->assertNotEquals(
            $tache1->id,
            $tache2->id
        );
    }

    public function test_entreprise_cannot_see_tasks_from_another_company_even_with_stage_filter(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire = $this->createStagiaire();

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise
        );

        $otherOffer = $this->createOffer(
            $otherEntreprise
        );

        $otherCandidature = $this->createCandidature(
            $stagiaire,
            $otherOffer
        );

        $otherStage = $this->createStage(
            $otherCandidature,
            $otherEncadrant
        );

        $otherTache = $this->createTache(
            $otherStage,
            $otherEncadrant
        );

        $response = $this->actingAs($entreprise)
            ->get(
                route(
                    'entreprise.taches.index',
                    ['stage_id' => $otherStage->id]
                )
            );

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 0)
            );

        $this->assertDatabaseHas('taches', [
            'id' => $otherTache->id,
            'id_Stage' => $otherStage->id,
        ]);
    }

    public function test_tasks_include_stage_student_and_supervisor_information(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);

        $candidature = $this->createCandidature(
            $stagiaire,
            $offre
        );

        $stage = $this->createStage(
            $candidature,
            $encadrant
        );

        $tache = $this->createTache(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->where(
                        'taches.data.0.id',
                        $tache->id
                    )
                    ->where(
                        'taches.data.0.stage.id',
                        $stage->id
                    )
                    ->where(
                        'taches.data.0.stage.candidature.id',
                        $candidature->id
                    )
                    ->where(
                        'taches.data.0.stage.candidature.stagiaire.user.id',
                        $stagiaire->id
                    )
                    ->where(
                        'taches.data.0.encadrant.user.id',
                        $encadrant->id
                    )
            );
    }

    public function test_tasks_are_ordered_by_due_date_descending(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);

        $stage = $this->createStage(
            $this->createCandidature($stagiaire, $offre),
            $encadrant
        );

        $olderTask = $this->createTache(
            $stage,
            $encadrant,
            'Older Task',
            now()->addDays(3)->toDateString()
        );

        $newerTask = $this->createTache(
            $stage,
            $encadrant,
            'Later Due Task',
            now()->addDays(10)->toDateString()
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 2)
                    ->where(
                        'taches.data.0.id',
                        $newerTask->id
                    )
                    ->where(
                        'taches.data.1.id',
                        $olderTask->id
                    )
            );
    }

    public function test_tasks_are_returned_with_pagination_structure(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);

        $stage = $this->createStage(
            $this->createCandidature($stagiaire, $offre),
            $encadrant
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Test Task'
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data')
                    ->has('taches.current_page')
                    ->has('taches.per_page')
                    ->has('taches.total')
                    ->where('taches.total', 1)
            );
    }
}
