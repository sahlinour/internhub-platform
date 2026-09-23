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

class ProgressTest extends TestCase
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

    private function createTache(
        Stage $stage,
        User $encadrant,
        string $titre,
        string $statut
    ): Tache {
        return Tache::create([
            'titre' => $titre,
            'description' => 'Tâche de test',
            'priorite' => 'Moyenne',
            'date_creation' => now()->toDateString(),
            'date_echeance' => now()->addDays(7)->toDateString(),
            'date_fin_effective' => $statut === 'terminee'
                ? now()->toDateString()
                : null,
            'statut' => $statut,
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_encadrant_can_view_progress(): void
    {
        $encadrant = $this->createEncadrant();

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Progress/Index')
                ->has('interns')
        );
    }

    public function test_progress_contains_own_internship_data(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->has('interns', 1)
                ->where('interns.0.stage_id', $stage->id)
                ->where(
                    'interns.0.stage.sujet',
                    'Développement de la plateforme'
                )
                ->where(
                    'interns.0.stage.date_debut',
                    $stage->date_debut->toISOString()
                )
                ->where(
                    'interns.0.stage.date_fin',
                    $stage->date_fin->toISOString()
                )
        );
    }

    public function test_progress_starts_at_zero_when_intern_has_no_tasks(): void
    {
        $encadrant = $this->createEncadrant();

        $this->createStage($encadrant);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where('interns.0.total_tasks', 0)
                ->where('interns.0.completed_tasks', 0)
                ->where('interns.0.progress', 0)
        );
    }

    public function test_progress_is_zero_when_no_task_is_completed(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche 1',
            'a_faire'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche 2',
            'en_cours'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where('interns.0.total_tasks', 2)
                ->where('interns.0.completed_tasks', 0)
                ->where('interns.0.progress', 0)
        );
    }

    public function test_progress_is_fifty_percent_when_half_tasks_are_completed(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche terminée',
            'terminee'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche en cours',
            'en_cours'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where('interns.0.total_tasks', 2)
                ->where('interns.0.completed_tasks', 1)
                ->where('interns.0.progress', 50)
        );
    }

    public function test_progress_is_one_hundred_percent_when_all_tasks_are_completed(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche terminée 1',
            'terminee'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche terminée 2',
            'terminee'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Tâche terminée 3',
            'terminee'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where('interns.0.total_tasks', 3)
                ->where('interns.0.completed_tasks', 3)
                ->where('interns.0.progress', 100)
        );
    }

    public function test_only_completed_tasks_are_counted_as_completed(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $this->createTache(
            $stage,
            $encadrant,
            'À faire',
            'a_faire'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'En cours',
            'en_cours'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Annulée',
            'annulee'
        );

        $this->createTache(
            $stage,
            $encadrant,
            'Terminée',
            'terminee'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where('interns.0.total_tasks', 4)
                ->where('interns.0.completed_tasks', 1)
                ->where('interns.0.progress', 25)
        );
    }

    public function test_encadrant_cannot_see_another_encadrants_internship_progress(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage1 = $this->createStage($encadrant1);
        $stage2 = $this->createStage($encadrant2);

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->has('interns', 1)
                ->where('interns.0.stage_id', $stage1->id)
        );

        $this->assertNotEquals($stage1->id, $stage2->id);
    }

    public function test_progress_contains_intern_information(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $stage->candidature->stagiaire->user->update([
            'nom_complet' => 'Nour Sahli',
            'email' => 'nour@example.com',
        ]);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.progress.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where(
                'interns.0.intern.nom_complet',
                'Nour Sahli'
            )
                ->where(
                    'interns.0.intern.email',
                    'nour@example.com'
                )
        );
    }

    public function test_guest_cannot_access_progress(): void
    {
        $response = $this->get(
            route('encadrant.progress.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_non_encadrant_cannot_access_progress(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $response = $this->actingAs($user)
            ->get(route('encadrant.progress.index'));

        $response->assertForbidden();
    }
}