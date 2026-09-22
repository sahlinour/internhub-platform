<?php

namespace Tests\Feature\Stagiaire;

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

class LogbookTest extends TestCase
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
            'date_creation' => '2026-09-03',
            'date_echeance' => '2026-09-09',
            'date_fin_effective' => null,
            'statut' => 'a_faire',
            'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant,
            'id_Stage' => $stage->id,
        ], $attributes));
    }

    private function createEvaluation(Stage $stage, array $attributes = []): Evaluation
    {
        return Evaluation::create(array_merge([
            'type_evaluation' => 'Evaluation finale',
            'note_technique' => 15,
            'note_relationnelle' => 14,
            'note_global' => 15,
            'remarque_encadrant' => 'Bon travail.',
            'date_evaluation' => '2026-09-20',
            'id_Stage' => $stage->id,
            'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant,
        ], $attributes));
    }

    public function test_stagiaire_without_internship_sees_empty_logbook(): void
    {
        [$user] = $this->createStagiaire();

        $response = $this->actingAs($user)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Logbook/Index')
                ->where('stage', null)
                ->where('weeklyTasks', [])
                ->where('availableTasks', [])
                ->where('evaluation', null)
        );
    }

    public function test_stagiaire_can_view_logbook(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createTask($stage);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Logbook/Index')
                ->where('stage.id', $stage->id)
        );
    }

    public function test_logbook_groups_tasks_by_internship_week(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $weekOneTask = $this->createTask($stage, [
            'titre' => 'Tâche semaine 1',
            'date_creation' => '2026-09-03',
        ]);

        $weekTwoTask = $this->createTask($stage, [
            'titre' => 'Tâche semaine 2',
            'date_creation' => '2026-09-10',
        ]);

        $weekThreeTask = $this->createTask($stage, [
            'titre' => 'Tâche semaine 3',
            'date_creation' => '2026-09-17',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('weeklyTasks', 3)
                ->where('weeklyTasks.0.week', 1)
                ->where('weeklyTasks.0.start_date', '2026-09-01')
                ->where('weeklyTasks.0.end_date', '2026-09-07')
                ->where('weeklyTasks.0.tasks.0.id', $weekOneTask->id)
                ->where('weeklyTasks.1.week', 2)
                ->where('weeklyTasks.1.start_date', '2026-09-08')
                ->where('weeklyTasks.1.end_date', '2026-09-14')
                ->where('weeklyTasks.1.tasks.0.id', $weekTwoTask->id)
                ->where('weeklyTasks.2.week', 3)
                ->where('weeklyTasks.2.start_date', '2026-09-15')
                ->where('weeklyTasks.2.end_date', '2026-09-21')
                ->where('weeklyTasks.2.tasks.0.id', $weekThreeTask->id)
        );
    }

    public function test_tasks_created_before_internship_start_are_in_week_one(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $task = $this->createTask($stage, [
            'titre' => 'Tâche avant le début du stage',
            'date_creation' => '2026-08-28',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('weeklyTasks', 1)
                ->where('weeklyTasks.0.week', 1)
                ->where('weeklyTasks.0.tasks.0.id', $task->id)
        );
    }

    public function test_logbook_contains_all_available_tasks(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $task1 = $this->createTask($stage, [
            'titre' => 'Tâche 1',
            'date_creation' => '2026-09-03',
        ]);

        $task2 = $this->createTask($stage, [
            'titre' => 'Tâche 2',
            'date_creation' => '2026-09-10',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('availableTasks', 2)
                ->where('availableTasks.0.id', $task1->id)
                ->where('availableTasks.1.id', $task2->id)
        );
    }

    public function test_logbook_returns_latest_evaluation(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createEvaluation($stage, [
            'note_global' => 12,
            'date_evaluation' => '2026-09-10',
        ]);

        $latestEvaluation = $this->createEvaluation($stage, [
            'note_global' => 17,
            'date_evaluation' => '2026-09-20',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('evaluation.id', $latestEvaluation->id)
                ->where('evaluation.note_global', 17)
        );
    }

    public function test_logbook_only_contains_data_from_own_internship(): void
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

        $evaluation1 = $this->createEvaluation($stage1);

        $this->createEvaluation($stage2, [
            'note_global' => 10,
        ]);

        $response = $this->actingAs($user1)
            ->get(route('stagiaire.logbook'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('stage.id', $stage1->id)
                ->has('weeklyTasks', 1)
                ->where('weeklyTasks.0.tasks.0.id', $task1->id)
                ->has('availableTasks', 1)
                ->where('availableTasks.0.id', $task1->id)
                ->where('evaluation.id', $evaluation1->id)
        );
    }
}