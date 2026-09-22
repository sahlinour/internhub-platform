<?php

namespace Tests\Feature\Stagiaire;

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

    private function createStagiaire(): array
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
        ]);

        return [$user, $stagiaire];
    }

    private function createStageForStagiaire(Stagiaire $stagiaire): Stage
    {
        $entrepriseUser = User::factory()->create([
            'role' => 'Entreprise',
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $entrepriseUser->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tanger',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de test',
        ]);

        $encadrantUser = User::factory()->create([
            'role' => 'Encadrant',
        ]);

        $encadrant = Encadrant::create([
            'user_id' => $encadrantUser->id,
            'poste' => 'Développeur Full Stack',
            'specialite' => 'Laravel',
            'departement' => 'IT',
            'entreprise_id' => $entreprise->user_id,
        ]);

        $offer = Offredestage::create([
            'titre' => 'Stage Laravel',
            'description' => 'Stage de développement Laravel',
            'duree' => '3 mois',
            'date_limite' => '2026-12-31',
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entreprise->user_id,
        ]);

        $candidature = Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite effectuer ce stage.',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        return Stage::create([
            'sujet' => 'Développement d’une application web',
            'date_debut' => '2026-09-01',
            'date_fin' => '2026-12-01',
            'statut' => 'En cours',
            'idUtilisateur_Encadrant' => $encadrant->user_id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    private function createTask(Stage $stage, array $attributes = []): Tache
    {
        return Tache::create(array_merge([
            'titre' => 'Développer une fonctionnalité',
            'description' => 'Développer une fonctionnalité Laravel.',
            'priorite' => 'Moyenne',
            'date_creation' => now()->toDateString(),
            'date_echeance' => now()->addDays(7)->toDateString(),
            'date_fin_effective' => null,
            'statut' => 'a_faire',
            'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant,
            'id_Stage' => $stage->id,
        ], $attributes));
    }

    public function test_stagiaire_can_view_tasks(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createTask($stage);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.taches.index'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_only_sees_tasks_from_own_stage(): void
    {
        [$user1, $stagiaire1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $stage1 = $this->createStageForStagiaire($stagiaire1);
        $stage2 = $this->createStageForStagiaire($stagiaire2);

        $task1 = $this->createTask($stage1, [
            'titre' => 'Tâche stagiaire 1',
        ]);

        $this->createTask($stage2, [
            'titre' => 'Tâche stagiaire 2',
        ]);

        $response = $this->actingAs($user1)
            ->get(route('stagiaire.taches.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Taches/Index')
                ->has('taches.data', 1)
                ->where('taches.data.0.id', $task1->id)
        );
    }

    public function test_stagiaire_can_filter_tasks_by_status(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $taskTodo = $this->createTask($stage, [
            'titre' => 'Tâche à faire',
            'statut' => 'a_faire',
        ]);

        $this->createTask($stage, [
            'titre' => 'Tâche terminée',
            'statut' => 'terminee',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.taches.index', [
                'statut' => 'a_faire',
            ]));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Taches/Index')
                ->has('taches.data', 1)
                ->where('taches.data.0.id', $taskTodo->id)
                ->where('filters.statut', 'a_faire')
        );
    }

    public function test_stagiaire_can_update_task_status(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $task = $this->createTask($stage);

        $response = $this->actingAs($user)
            ->patch(
                route('stagiaire.taches.updateStatus', $task->id),
                [
                    'statut' => 'en_cours',
                ]
            );

        $response->assertSessionHas(
            'message',
            'Task status updated successfully.'
        );

        $task->refresh();

        $this->assertSame('en_cours', $task->statut);
        $this->assertNull($task->date_fin_effective);
    }

    public function test_completing_task_sets_completion_date(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $task = $this->createTask($stage);

        $response = $this->actingAs($user)
            ->patch(
                route('stagiaire.taches.updateStatus', $task->id),
                [
                    'statut' => 'terminee',
                ]
            );

        $response->assertSessionHasNoErrors();

        $task->refresh();

        $this->assertSame('terminee', $task->statut);
        $this->assertNotNull($task->date_fin_effective);
        $this->assertSame(
            now()->toDateString(),
            $task->date_fin_effective->toDateString()
        );
    }

    public function test_stagiaire_cannot_update_task_from_another_stage(): void
    {
        [$user1, $stagiaire1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $stage2 = $this->createStageForStagiaire($stagiaire2);

        $task = $this->createTask($stage2);

        $response = $this->actingAs($user1)
            ->patch(
                route('stagiaire.taches.updateStatus', $task->id),
                [
                    'statut' => 'terminee',
                ]
            );

        $response->assertNotFound();

        $task->refresh();

        $this->assertSame('a_faire', $task->statut);
        $this->assertNull($task->date_fin_effective);
    }

    public function test_task_status_must_be_valid(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $task = $this->createTask($stage);

        $response = $this->actingAs($user)
            ->patch(
                route('stagiaire.taches.updateStatus', $task->id),
                [
                    'statut' => 'invalid_status',
                ]
            );

        $response->assertSessionHasErrors('statut');

        $task->refresh();

        $this->assertSame('a_faire', $task->statut);
    }
}