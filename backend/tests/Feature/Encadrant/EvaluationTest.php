<?php

namespace Tests\Feature\Encadrant;

use App\Models\Candidature;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Evaluation;
use App\Models\Offredestage;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluationTest extends TestCase
{
    use RefreshDatabase;

    private function createEncadrant(): User
    {
        $entreprise = User::factory()->create([
            'role' => 'Entreprise',
        ]);

        Entreprise::create([
            'user_id' => $entreprise->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tangier',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de test',
        ]);

        $encadrant = User::factory()->create([
            'role' => 'Encadrant',
        ]);

        Encadrant::create([
            'user_id' => $encadrant->id,
            'entreprise_id' => $entreprise->id,
            'poste' => 'Encadrant',
            'specialite' => 'Développement',
            'departement' => 'IT',
        ]);

        return $encadrant;
    }

    private function createStagiaire(): User
    {
        $stagiaire = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $stagiaire->id,
        ]);

        return $stagiaire;
    }

    private function createStage(User $encadrant): Stage
    {
        $stagiaire = $this->createStagiaire();

        $entreprise = $encadrant->encadrant->entreprise;

        $offre = Offredestage::create([
            'titre' => 'Stage Développement Web',
            'description' => 'Stage de développement',
            'duree' => '3 mois',
            'date_limite' => now()->addMonth()->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entreprise->user_id,
        ]);

        $candidature = Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite rejoindre votre entreprise.',
            'piece_jointe' => null,
            'cv_url' => null,
            'idUtilisateur_Stagiaire' => $stagiaire->id,
            'id_Offre_De_Stage' => $offre->id,
        ]);

        return Stage::create([
            'sujet' => 'Développement de la plateforme',
            'date_debut' => now()->toDateString(),
            'date_fin' => now()->addMonths(3)->toDateString(),
            'statut' => 'en_cours',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    private function createCompletedTask(
        Stage $stage,
        User $encadrant,
        string $titre = 'Tâche terminée'
    ): Tache {
        return Tache::create([
            'titre' => $titre,
            'description' => 'Tâche de test',
            'priorite' => 'Moyenne',
            'date_creation' => now()->toDateString(),
            'date_echeance' => now()->addDays(7)->toDateString(),
            'date_fin_effective' => now()->toDateString(),
            'statut' => 'terminee',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    private function createPendingTask(
        Stage $stage,
        User $encadrant,
        string $titre = 'Tâche en attente'
    ): Tache {
        return Tache::create([
            'titre' => $titre,
            'description' => 'Tâche de test',
            'priorite' => 'Moyenne',
            'date_creation' => now()->toDateString(),
            'date_echeance' => now()->addDays(7)->toDateString(),
            'date_fin_effective' => null,
            'statut' => 'a_faire',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    private function createEvaluation(
        User $encadrant,
        Stage $stage,
        float $technique = 16,
        float $relationnelle = 14
    ): Evaluation {
        return Evaluation::create([
            'type_evaluation' => 'Évaluation finale',
            'note_technique' => $technique,
            'note_relationnelle' => $relationnelle,
            'note_global' => ($technique + $relationnelle) / 2,
            'remarque_encadrant' => 'Bon travail.',
            'date_evaluation' => now(),
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_encadrant_can_view_evaluations(): void
    {
        $encadrant = $this->createEncadrant();

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.evaluations.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Evaluations/Index')
                ->has('evaluations')
                ->where('selectedStage', null)
        );
    }

    public function test_evaluations_index_contains_only_own_evaluations(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage1 = $this->createStage($encadrant1);
        $stage2 = $this->createStage($encadrant2);

        $evaluation1 = $this->createEvaluation(
            $encadrant1,
            $stage1
        );

        $this->createEvaluation(
            $encadrant2,
            $stage2
        );

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.evaluations.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->has('evaluations.data', 1)
                ->where(
                    'evaluations.data.0.id',
                    $evaluation1->id
                )
        );
    }

    public function test_selected_stage_contains_intern_offer_and_progress_data(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $this->createCompletedTask(
            $stage,
            $encadrant,
            'Tâche terminée 1'
        );

        $this->createCompletedTask(
            $stage,
            $encadrant,
            'Tâche terminée 2'
        );

        $this->createPendingTask(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->get(
                route(
                    'encadrant.evaluations.index',
                    ['stage_id' => $stage->id]
                )
            );

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where(
                'selectedStage.id',
                $stage->id
            )
                ->where(
                    'selectedStage.sujet',
                    'Développement de la plateforme'
                )
                ->where(
                    'selectedStage.total_tasks',
                    3
                )
                ->where(
                    'selectedStage.completed_tasks',
                    2
                )
                ->where(
                    'selectedStage.progress',
                    67
                )
                ->has('selectedStage.intern')
                ->has('selectedStage.offer')
        );
    }

    public function test_selected_stage_returns_zero_progress_without_tasks(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $response = $this->actingAs($encadrant)
            ->get(
                route(
                    'encadrant.evaluations.index',
                    ['stage_id' => $stage->id]
                )
            );

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where(
                'selectedStage.total_tasks',
                0
            )
                ->where(
                    'selectedStage.completed_tasks',
                    0
                )
                ->where(
                    'selectedStage.progress',
                    0
                )
        );
    }

    public function test_encadrant_can_create_evaluation_when_all_tasks_are_completed(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $this->createCompletedTask(
            $stage,
            $encadrant,
            'Tâche 1'
        );

        $this->createCompletedTask(
            $stage,
            $encadrant,
            'Tâche 2'
        );

        $response = $this->actingAs($encadrant)
            ->post(
                route('encadrant.evaluations.store'),
                [
                    'id_Stage' => $stage->id,
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 18,
                    'note_relationnelle' => 16,
                    'remarque_encadrant' => 'Très bon travail.',
                ]
            );

        $response->assertRedirect(
            route('encadrant.evaluations.index')
        );

        $this->assertDatabaseHas('evaluations', [
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
            'type_evaluation' => 'Évaluation finale',
            'note_technique' => 18,
            'note_relationnelle' => 16,
            'note_global' => 17,
            'remarque_encadrant' => 'Très bon travail.',
        ]);
    }

    public function test_evaluation_global_score_is_calculated_correctly(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $this->createCompletedTask(
            $stage,
            $encadrant
        );

        $this->actingAs($encadrant)
            ->post(
                route('encadrant.evaluations.store'),
                [
                    'id_Stage' => $stage->id,
                    'type_evaluation' => 'Évaluation technique',
                    'note_technique' => 15,
                    'note_relationnelle' => 13,
                    'remarque_encadrant' => null,
                ]
            );

        $evaluation = Evaluation::first();

        $this->assertNotNull($evaluation);
        $this->assertSame(14.0, $evaluation->note_global);
    }

    public function test_evaluation_creation_is_rejected_when_stage_has_no_tasks(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $response = $this->actingAs($encadrant)
            ->post(
                route('encadrant.evaluations.store'),
                [
                    'id_Stage' => $stage->id,
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 16,
                    'note_relationnelle' => 15,
                    'remarque_encadrant' => null,
                ]
            );

        $response->assertSessionHasErrors('id_Stage');

        $this->assertDatabaseCount('evaluations', 0);
    }

    public function test_evaluation_creation_is_rejected_when_not_all_tasks_are_completed(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $this->createCompletedTask(
            $stage,
            $encadrant,
            'Tâche terminée'
        );

        $this->createPendingTask(
            $stage,
            $encadrant,
            'Tâche non terminée'
        );

        $response = $this->actingAs($encadrant)
            ->post(
                route('encadrant.evaluations.store'),
                [
                    'id_Stage' => $stage->id,
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 16,
                    'note_relationnelle' => 15,
                    'remarque_encadrant' => null,
                ]
            );

        $response->assertSessionHasErrors('id_Stage');

        $this->assertDatabaseCount('evaluations', 0);
    }

    public function test_encadrant_cannot_create_evaluation_for_another_encadrants_stage(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage = $this->createStage($encadrant2);

        $this->createCompletedTask(
            $stage,
            $encadrant2
        );

        $response = $this->actingAs($encadrant1)
            ->post(
                route('encadrant.evaluations.store'),
                [
                    'id_Stage' => $stage->id,
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 17,
                    'note_relationnelle' => 17,
                    'remarque_encadrant' => null,
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseCount('evaluations', 0);
    }

    public function test_evaluation_requires_valid_scores(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $this->createCompletedTask(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->post(
                route('encadrant.evaluations.store'),
                [
                    'id_Stage' => $stage->id,
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 21,
                    'note_relationnelle' => -1,
                    'remarque_encadrant' => null,
                ]
            );

        $response->assertSessionHasErrors([
            'note_technique',
            'note_relationnelle',
        ]);

        $this->assertDatabaseCount('evaluations', 0);
    }

    public function test_encadrant_can_update_own_evaluation(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $this->createCompletedTask(
            $stage,
            $encadrant
        );

        $evaluation = $this->createEvaluation(
            $encadrant,
            $stage,
            12,
            10
        );

        $response = $this->actingAs($encadrant)
            ->put(
                route(
                    'encadrant.evaluations.update',
                    $evaluation->id
                ),
                [
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 18,
                    'note_relationnelle' => 14,
                    'remarque_encadrant' => 'Évaluation mise à jour.',
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('evaluations', [
            'id' => $evaluation->id,
            'type_evaluation' => 'Évaluation finale',
            'note_technique' => 18,
            'note_relationnelle' => 14,
            'note_global' => 16,
            'remarque_encadrant' => 'Évaluation mise à jour.',
        ]);
    }

    public function test_encadrant_cannot_update_another_encadrants_evaluation(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage2 = $this->createStage($encadrant2);

        $evaluation = $this->createEvaluation(
            $encadrant2,
            $stage2
        );

        $response = $this->actingAs($encadrant1)
            ->put(
                route(
                    'encadrant.evaluations.update',
                    $evaluation->id
                ),
                [
                    'type_evaluation' => 'Tentative non autorisée',
                    'note_technique' => 20,
                    'note_relationnelle' => 20,
                    'remarque_encadrant' => null,
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('evaluations', [
            'id' => $evaluation->id,
            'type_evaluation' => 'Évaluation finale',
            'note_technique' => 16,
            'note_relationnelle' => 14,
            'note_global' => 15,
        ]);
    }

    public function test_update_recalculates_global_score(): void
    {
        $encadrant = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $evaluation = $this->createEvaluation(
            $encadrant,
            $stage,
            10,
            10
        );

        $this->actingAs($encadrant)
            ->put(
                route(
                    'encadrant.evaluations.update',
                    $evaluation->id
                ),
                [
                    'type_evaluation' => 'Évaluation finale',
                    'note_technique' => 19,
                    'note_relationnelle' => 15,
                    'remarque_encadrant' => null,
                ]
            );

        $this->assertDatabaseHas('evaluations', [
            'id' => $evaluation->id,
            'note_technique' => 19,
            'note_relationnelle' => 15,
            'note_global' => 17,
        ]);
    }

    public function test_guest_cannot_access_evaluations(): void
    {
        $response = $this->get(
            route('encadrant.evaluations.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_non_encadrant_cannot_access_evaluations(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $response = $this->actingAs($user)
            ->get(route('encadrant.evaluations.index'));

        $response->assertForbidden();
    }
}