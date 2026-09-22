<?php

namespace Tests\Feature\Stagiaire;

use App\Models\Candidature;
use App\Models\Document;
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

class ProgressTest extends TestCase
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

    private function createStageForStagiaire(
        Stagiaire $stagiaire,
        array $attributes = []
    ): Stage {
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
            'date_postulation' => '2026-08-25',
            'lettre_de_motivation' => 'Je souhaite effectuer ce stage.',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        return Stage::create(array_merge([
            'sujet' => 'Développement d’une application web',
            'date_debut' => '2026-09-01',
            'date_fin' => '2026-09-28',
            'statut' => 'En cours',
            'idUtilisateur_Encadrant' => $encadrant->user_id,
            'id_Candidature' => $candidature->id,
        ], $attributes));
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

    private function createDocument(Stage $stage, array $attributes = []): Document
    {
        return Document::create(array_merge([
            'nom' => 'Rapport de stage',
            'version' => 'v1.0',
            'statut' => 'en_attente',
            'fichier_url' => 'documents/rapport.pdf',
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

    public function test_stagiaire_without_internship_sees_zero_progress(): void
    {
        [$user] = $this->createStagiaire();

        $response = $this->actingAs($user)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Progress/Index')
                ->where('stage', null)
                ->where('stats.stage_progress', 0)
                ->where('stats.tasks_total', 0)
                ->where('stats.tasks_completed', 0)
                ->where('stats.tasks_in_progress', 0)
                ->where('stats.tasks_todo', 0)
                ->where('stats.tasks_progress', 0)
                ->where('stats.documents_total', 0)
                ->where('stats.documents_pending', 0)
                ->where('stats.documents_approved', 0)
                ->where('stats.documents_rejected', 0)
                ->where('stats.evaluation', null)
                ->where('taskStatus', [])
                ->where('taskPriority', [])
                ->where('weeklyProgress', [])
        );
    }

    public function test_stagiaire_can_view_progress(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Progress/Index')
                ->where('stage.id', $stage->id)
                ->where('stage.sujet', $stage->sujet)
                ->where('stage.statut', 'En cours')
        );
    }

    public function test_progress_calculates_task_statistics(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createTask($stage, [
            'statut' => 'terminee',
            'priorite' => 'Haute',
        ]);

        $this->createTask($stage, [
            'statut' => 'en_cours',
            'priorite' => 'Moyenne',
        ]);

        $this->createTask($stage, [
            'statut' => 'a_faire',
            'priorite' => 'Basse',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('stats.tasks_total', 3)
                ->where('stats.tasks_completed', 1)
                ->where('stats.tasks_in_progress', 1)
                ->where('stats.tasks_todo', 1)
                ->where('stats.tasks_progress', 33)
                ->where('taskStatus.0.label', 'Completed')
                ->where('taskStatus.0.value', 1)
                ->where('taskStatus.1.label', 'In Progress')
                ->where('taskStatus.1.value', 1)
                ->where('taskStatus.2.label', 'To Do')
                ->where('taskStatus.2.value', 1)
        );
    }

    public function test_progress_calculates_task_priority_statistics(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createTask($stage, [
            'priorite' => 'Haute',
        ]);

        $this->createTask($stage, [
            'priorite' => 'Haute',
        ]);

        $this->createTask($stage, [
            'priorite' => 'Moyenne',
        ]);

        $this->createTask($stage, [
            'priorite' => 'Basse',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('taskPriority.0.label', 'High')
                ->where('taskPriority.0.value', 2)
                ->where('taskPriority.1.label', 'Medium')
                ->where('taskPriority.1.value', 1)
                ->where('taskPriority.2.label', 'Low')
                ->where('taskPriority.2.value', 1)
        );
    }

    public function test_progress_calculates_document_statistics(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createDocument($stage, [
            'statut' => 'en_attente',
        ]);

        $this->createDocument($stage, [
            'statut' => 'valide',
        ]);

        $this->createDocument($stage, [
            'statut' => 'rejete',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('stats.documents_total', 3)
                ->where('stats.documents_pending', 1)
                ->where('stats.documents_approved', 1)
                ->where('stats.documents_rejected', 1)
        );
    }

    public function test_progress_returns_latest_evaluation(): void
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
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('stats.evaluation.id', $latestEvaluation->id)
                ->where('stats.evaluation.note_global', 17)
        );
    }

    public function test_progress_calculates_weekly_task_progress(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $this->createTask($stage, [
            'date_creation' => '2026-09-02',
            'statut' => 'terminee',
        ]);

        $this->createTask($stage, [
            'date_creation' => '2026-09-04',
            'statut' => 'a_faire',
        ]);

        $this->createTask($stage, [
            'date_creation' => '2026-09-10',
            'statut' => 'terminee',
        ]);

        $this->createTask($stage, [
            'date_creation' => '2026-09-11',
            'statut' => 'en_cours',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('weeklyProgress', 4)
                ->where('weeklyProgress.0.week', 1)
                ->where('weeklyProgress.0.start_date', '2026-09-01')
                ->where('weeklyProgress.0.end_date', '2026-09-07')
                ->where('weeklyProgress.0.total_tasks', 2)
                ->where('weeklyProgress.0.completed_tasks', 1)
                ->where('weeklyProgress.0.progress', 50)
                ->where('weeklyProgress.1.week', 2)
                ->where('weeklyProgress.1.start_date', '2026-09-08')
                ->where('weeklyProgress.1.end_date', '2026-09-14')
                ->where('weeklyProgress.1.total_tasks', 2)
                ->where('weeklyProgress.1.completed_tasks', 1)
                ->where('weeklyProgress.1.progress', 50)
        );
    }

    public function test_progress_only_contains_data_from_own_internship(): void
    {
        [$user1, $stagiaire1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $stage1 = $this->createStageForStagiaire($stagiaire1);
        $stage2 = $this->createStageForStagiaire($stagiaire2);

        $this->createTask($stage1, [
            'statut' => 'terminee',
        ]);

        $this->createTask($stage2, [
            'statut' => 'terminee',
        ]);

        $this->createDocument($stage1);

        $this->createDocument($stage2);

        $response = $this->actingAs($user1)
            ->get(route('stagiaire.progress'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('stage.id', $stage1->id)
                ->where('stats.tasks_total', 1)
                ->where('stats.tasks_completed', 1)
                ->where('stats.documents_total', 1)
                ->has('weeklyProgress', 4)
        );
    }
}