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

class InternshipJourneyTest extends TestCase
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
            'date_evaluation' => now()->toDateString(),
            'id_Stage' => $stage->id,
            'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant,
        ], $attributes));
    }

    public function test_stagiaire_without_internship_sees_empty_journey(): void
    {
        [$user] = $this->createStagiaire();

        $response = $this->actingAs($user)
            ->get(route('stagiaire.internship-journey'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/InternshipJourney/Index')
                ->where('stage', null)
                ->where('tasks', [])
                ->where('documents', [])
                ->where('evaluation', null)
        );
    }

    public function test_stagiaire_can_view_internship_journey(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.internship-journey'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/InternshipJourney/Index')
                ->where('stage.id', $stage->id)
                ->where('stage.sujet', $stage->sujet)
        );
    }

    public function test_journey_contains_tasks_documents_and_evaluation(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $task = $this->createTask($stage);

        $document = $this->createDocument($stage);

        $evaluation = $this->createEvaluation($stage);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.internship-journey'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('tasks', 1)
                ->where('tasks.0.id', $task->id)
                ->has('documents', 1)
                ->where('documents.0.id', $document->id)
                ->where('evaluation.id', $evaluation->id)
        );
    }

    public function test_journey_only_contains_data_from_own_internship(): void
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

        $document1 = $this->createDocument($stage1, [
            'nom' => 'Document stagiaire 1',
        ]);

        $this->createDocument($stage2, [
            'nom' => 'Document stagiaire 2',
        ]);

        $evaluation1 = $this->createEvaluation($stage1);

        $this->createEvaluation($stage2, [
            'note_global' => 10,
        ]);

        $response = $this->actingAs($user1)
            ->get(route('stagiaire.internship-journey'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('stage.id', $stage1->id)
                ->has('tasks', 1)
                ->where('tasks.0.id', $task1->id)
                ->has('documents', 1)
                ->where('documents.0.id', $document1->id)
                ->where('evaluation.id', $evaluation1->id)
        );
    }

    public function test_journey_returns_latest_evaluation(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $oldEvaluation = $this->createEvaluation($stage, [
            'note_global' => 12,
            'date_evaluation' => '2026-09-10',
        ]);

        $latestEvaluation = $this->createEvaluation($stage, [
            'note_global' => 17,
            'date_evaluation' => '2026-09-20',
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.internship-journey'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->where('evaluation.id', $latestEvaluation->id)
                ->where('evaluation.note_global', 17)
        );

        $this->assertNotEquals(
            $oldEvaluation->id,
            $latestEvaluation->id
        );
    }
}