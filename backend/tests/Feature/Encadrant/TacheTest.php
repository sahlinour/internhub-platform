<?php

namespace Tests\Feature\Encadrant;

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
        ?string $dateEcheance = null,
        string $statut = 'a_faire'
    ): Tache {
        return Tache::create([
            'titre' => $titre,
            'description' => 'Développer et tester la fonctionnalité.',
            'priorite' => 'Moyenne',
            'date_creation' => now()->toDateString(),
            'date_echeance' => $dateEcheance ?? now()->addDays(7)->toDateString(),
            'date_fin_effective' => null,
            'statut' => $statut,
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_encadrant_can_view_own_tasks(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $tache = $this->createTache($stage, $encadrant);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where('taches.data.0.id', $tache->id)
                    ->where('taches.data.0.id_Stage', $stage->id)
            );
    }

    public function test_encadrant_cannot_view_another_encadrants_tasks(): void
    {
        $entreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($entreprise);

        $stage1 = $this->createStage(
            $this->createCandidature(
                $stagiaire1,
                $this->createOffer($entreprise)
            ),
            $encadrant1
        );

        $stage2 = $this->createStage(
            $this->createCandidature(
                $stagiaire2,
                $this->createOffer($entreprise)
            ),
            $encadrant2
        );

        $this->createTache($stage1, $encadrant1, 'Task 1');
        $task2 = $this->createTache($stage2, $encadrant2, 'Task 2');

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where('taches.data.0.titre', 'Task 1')
            );

        $this->assertDatabaseHas('taches', [
            'id' => $task2->id,
        ]);
    }

    public function test_encadrant_can_filter_tasks_by_stage(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $stage1 = $this->createStage(
            $this->createCandidature(
                $stagiaire1,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $stage2 = $this->createStage(
            $this->createCandidature(
                $stagiaire2,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $task1 = $this->createTache($stage1, $encadrant, 'Stage 1 Task');
        $this->createTache($stage2, $encadrant, 'Stage 2 Task');

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.index', [
                'stage_id' => $stage1->id,
            ]));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where('taches.data.0.id', $task1->id)
                    ->where('filters.stage_id', (string) $stage1->id)
            );
    }

    public function test_encadrant_can_filter_tasks_by_status(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $taskTodo = $this->createTache(
            $stage,
            $encadrant,
            'Todo Task',
            now()->addDays(5)->toDateString(),
            'a_faire'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'In Progress Task',
            now()->addDays(6)->toDateString(),
            'en_cours'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.index', [
                'statut' => 'a_faire',
            ]));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 1)
                    ->where('taches.data.0.id', $taskTodo->id)
                    ->where('filters.statut', 'a_faire')
            );
    }

    public function test_tasks_are_ordered_by_due_date_ascending(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $laterTask = $this->createTache(
            $stage,
            $encadrant,
            'Later Task',
            now()->addDays(10)->toDateString()
        );

        $earlierTask = $this->createTache(
            $stage,
            $encadrant,
            'Earlier Task',
            now()->addDays(2)->toDateString()
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('taches.data', 2)
                    ->where('taches.data.0.id', $earlierTask->id)
                    ->where('taches.data.1.id', $laterTask->id)
            );
    }

    public function test_tasks_include_stage_and_stagiaire_information(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $task = $this->createTache($stage, $encadrant);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->where('taches.data.0.id', $task->id)
                    ->where('taches.data.0.stage.id', $stage->id)
                    ->where(
                        'taches.data.0.stage.candidature.stagiaire.user.id',
                        $stagiaire->id
                    )
            );
    }

    public function test_encadrant_can_view_create_page(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.create'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('stages', 1)
                    ->where('stages.0.id', $stage->id)
                    ->where('selectedStageId', null)
            );
    }

    public function test_create_page_accepts_own_stage_as_selected_stage(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.taches.create', [
                'stage' => $stage->id,
            ]));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->where('selectedStageId', (string) $stage->id)
            );
    }

    public function test_create_page_rejects_another_encadrants_stage(): void
    {
        $entreprise = $this->createEntreprise();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($entreprise);

        $stage = $this->createStage(
            $this->createCandidature(
                $this->createStagiaire(),
                $this->createOffer($entreprise)
            ),
            $encadrant2
        );

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.taches.create', [
                'stage' => $stage->id,
            ]));

        $response->assertForbidden();
    }

    public function test_encadrant_can_create_task_on_own_stage(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->post(route('encadrant.taches.store'), [
                'titre' => 'Créer le dashboard',
                'description' => 'Développer le dashboard stagiaire.',
                'priorite' => 'Haute',
                'date_echeance' => now()->addDays(5)->toDateString(),
                'id_Stage' => $stage->id,
            ]);

        $response->assertRedirect(route('encadrant.taches.index'));

        $response->assertSessionHas(
            'message',
            'Task assigned successfully.'
        );

        $this->assertDatabaseHas('taches', [
            'titre' => 'Créer le dashboard',
            'priorite' => 'Haute',
            'statut' => 'a_faire',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_encadrant_cannot_create_task_on_another_encadrants_stage(): void
    {
        $entreprise = $this->createEntreprise();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($entreprise);

        $stage = $this->createStage(
            $this->createCandidature(
                $this->createStagiaire(),
                $this->createOffer($entreprise)
            ),
            $encadrant2
        );

        $response = $this->actingAs($encadrant1)
            ->post(route('encadrant.taches.store'), [
                'titre' => 'Unauthorized task',
                'description' => 'Should not be created.',
                'priorite' => 'Haute',
                'date_echeance' => now()->addDays(5)->toDateString(),
                'id_Stage' => $stage->id,
            ]);

        $response->assertNotFound();

        $this->assertDatabaseMissing('taches', [
            'titre' => 'Unauthorized task',
        ]);
    }

    public function test_task_creation_validates_required_fields(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);

        $response = $this->actingAs($encadrant)
            ->post(route('encadrant.taches.store'), []);

        $response->assertSessionHasErrors([
            'titre',
            'priorite',
            'date_echeance',
            'id_Stage',
        ]);
    }

    public function test_task_creation_rejects_past_due_date(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);

        $response = $this->actingAs($encadrant)
            ->post(route('encadrant.taches.store'), [
                'titre' => 'Past task',
                'description' => 'Invalid date.',
                'priorite' => 'Moyenne',
                'date_echeance' => now()->subDay()->toDateString(),
                'id_Stage' => 999999,
            ]);

        $response->assertSessionHasErrors([
            'date_echeance',
            'id_Stage',
        ]);
    }

    public function test_task_creation_rejects_invalid_priority(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);

        $response = $this->actingAs($encadrant)
            ->post(route('encadrant.taches.store'), [
                'titre' => 'Invalid priority task',
                'priorite' => 'Impossible',
                'date_echeance' => now()->addDays(5)->toDateString(),
                'id_Stage' => 999999,
            ]);

        $response->assertSessionHasErrors([
            'priorite',
            'id_Stage',
        ]);
    }

    public function test_encadrant_can_update_own_task(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $task = $this->createTache($stage, $encadrant);

        $response = $this->actingAs($encadrant)
            ->put(route('encadrant.taches.update', $task->id), [
                'titre' => 'Updated task',
                'description' => 'Updated description',
                'priorite' => 'Urgente',
                'date_echeance' => now()->addDays(10)->toDateString(),
                'statut' => 'en_cours',
            ]);

        $response->assertSessionHas(
            'message',
            'Tâche mise à jour avec succès.'
        );

        $this->assertDatabaseHas('taches', [
            'id' => $task->id,
            'titre' => 'Updated task',
            'priorite' => 'Urgente',
            'statut' => 'en_cours',
            'date_fin_effective' => null,
        ]);
    }

    public function test_encadrant_cannot_update_another_encadrants_task(): void
    {
        $entreprise = $this->createEntreprise();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($entreprise);

        $stage = $this->createStage(
            $this->createCandidature(
                $this->createStagiaire(),
                $this->createOffer($entreprise)
            ),
            $encadrant2
        );

        $task = $this->createTache($stage, $encadrant2);

        $response = $this->actingAs($encadrant1)
            ->put(route('encadrant.taches.update', $task->id), [
                'titre' => 'Unauthorized update',
                'description' => 'Should not update.',
                'priorite' => 'Haute',
                'date_echeance' => now()->addDays(5)->toDateString(),
                'statut' => 'en_cours',
            ]);

        $response->assertNotFound();

        $this->assertDatabaseHas('taches', [
            'id' => $task->id,
            'titre' => 'Développer le module de connexion',
            'statut' => 'a_faire',
        ]);
    }

    public function test_completing_task_sets_effective_end_date(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $task = $this->createTache(
            $stage,
            $encadrant,
            'Complete this task'
        );

        $this->actingAs($encadrant)
            ->put(route('encadrant.taches.update', $task->id), [
                'titre' => $task->titre,
                'description' => $task->description,
                'priorite' => $task->priorite,
                'date_echeance' => $task->date_echeance->toDateString(),
                'statut' => 'terminee',
            ]);

        $task->refresh();

        $this->assertSame('terminee', $task->statut);
        $this->assertNotNull($task->date_fin_effective);
        $this->assertSame(
            now()->toDateString(),
            $task->date_fin_effective->toDateString()
        );
    }

    public function test_reopening_completed_task_clears_effective_end_date(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $task = $this->createTache(
            $stage,
            $encadrant,
            'Reopen task',
            now()->addDays(5)->toDateString(),
            'terminee'
        );

        $task->update([
            'date_fin_effective' => now()->subDay()->toDateString(),
        ]);

        $this->actingAs($encadrant)
            ->put(route('encadrant.taches.update', $task->id), [
                'titre' => $task->titre,
                'description' => $task->description,
                'priorite' => $task->priorite,
                'date_echeance' => $task->date_echeance->toDateString(),
                'statut' => 'en_cours',
            ]);

        $task->refresh();

        $this->assertSame('en_cours', $task->statut);
        $this->assertNull($task->date_fin_effective);
    }

    public function test_task_update_validates_status(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);

        $response = $this->actingAs($encadrant)
            ->put(route('encadrant.taches.update', 999999), [
                'titre' => 'Test',
                'description' => 'Test',
                'priorite' => 'Moyenne',
                'date_echeance' => now()->addDays(5)->toDateString(),
                'statut' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors('statut');
    }

    public function test_encadrant_can_delete_own_task(): void
    {
        $entreprise = $this->createEntreprise();
        $encadrant = $this->createEncadrant($entreprise);
        $stagiaire = $this->createStagiaire();

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $this->createOffer($entreprise)
            ),
            $encadrant
        );

        $task = $this->createTache($stage, $encadrant);

        $response = $this->actingAs($encadrant)
            ->delete(route('encadrant.taches.destroy', $task->id));

        $response->assertSessionHas(
            'message',
            'Tâche supprimée avec succès.'
        );

        $this->assertSoftDeleted('taches', [
            'id' => $task->id,
        ]);
    }

    public function test_encadrant_cannot_delete_another_encadrants_task(): void
    {
        $entreprise = $this->createEntreprise();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($entreprise);

        $stage = $this->createStage(
            $this->createCandidature(
                $this->createStagiaire(),
                $this->createOffer($entreprise)
            ),
            $encadrant2
        );

        $task = $this->createTache($stage, $encadrant2);

        $response = $this->actingAs($encadrant1)
            ->delete(route('encadrant.taches.destroy', $task->id));

        $response->assertNotFound();

        $this->assertDatabaseHas('taches', [
            'id' => $task->id,
            'deleted_at' => null,
        ]);
    }

    public function test_guest_cannot_access_encadrant_tasks(): void
    {
        $response = $this->get(route('encadrant.taches.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_encadrant_cannot_access_encadrant_tasks(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'etat' => 'active',
        ]);

        $response = $this->actingAs($user)
            ->get(route('encadrant.taches.index'));

        $response->assertForbidden();
    }
}