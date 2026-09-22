<?php

namespace Tests\Feature\Encadrant;

use App\Models\Candidature;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StageTest extends TestCase
{
    use RefreshDatabase;

    private function createEncadrant(array $data = []): array
    {
        $entrepriseUser = User::factory()->create([
            'role' => 'Entreprise',
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $entrepriseUser->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tangier',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de test',
        ]);

        $user = User::factory()->create(array_merge([
            'role' => 'Encadrant',
        ], $data));

        $encadrant = Encadrant::create([
            'user_id' => $user->id,
            'poste' => 'Encadrant',
            'specialite' => 'Développement Web',
            'departement' => 'Informatique',
            'entreprise_id' => $entreprise->user_id,
        ]);

        return [$user, $encadrant, $entreprise];
    }

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

    private function createStage(
        Encadrant $encadrant,
        string $statut = 'en_cours',
        ?string $sujet = null,
        ?string $dateDebut = null,
        ?string $dateFin = null
    ): Stage {
        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $entrepriseUser = User::where('role', 'Entreprise')->first();

        $offre = Offredestage::create([
            'titre' => 'Stage de développement',
            'description' => 'Stage de test',
            'duree' => '3 mois',
            'date_limite' => now()->addMonth()->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entrepriseUser->id,
        ]);

        $candidature = Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Lettre de motivation de test',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offre->id,
        ]);

        return Stage::create([
            'sujet' => $sujet ?? 'Application Web',
            'date_debut' => $dateDebut ?? now()->subDays(10)->toDateString(),
            'date_fin' => $dateFin ?? now()->addMonths(2)->toDateString(),
            'statut' => $statut,
            'idUtilisateur_Encadrant' => $encadrant->user_id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    public function test_encadrant_can_view_own_stages(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage1 = $this->createStage(
            $encadrant,
            'en_cours',
            'Projet Laravel'
        );

        $stage2 = $this->createStage(
            $encadrant,
            'termine',
            'Projet Vue.js'
        );

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stages.index'));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Stagiaires/Index')
            ->has('stages.data', 2)
            ->where('stages.data', fn ($stages) =>collect($stages)->pluck('id')->sort()->values()->all()=== collect([$stage1->id, $stage2->id])->sort()->values()->all())
        );
    }

    public function test_encadrant_cannot_view_another_encadrants_stages(): void
    {
        [$user1, $encadrant1] = $this->createEncadrant();
        [, $encadrant2] = $this->createEncadrant();

        $ownStage = $this->createStage(
            $encadrant1,
            'en_cours',
            'Mon stage'
        );

        $otherStage = $this->createStage(
            $encadrant2,
            'en_cours',
            'Autre stage'
        );

        $response = $this
            ->actingAs($user1)
            ->get(route('encadrant.stages.index'));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Stagiaires/Index')
            ->has('stages.data', 1)
            ->where('stages.data.0.id', $ownStage->id)
            ->missing('stages.data.1')
        );

        $this->assertDatabaseHas('stages', [
            'id' => $otherStage->id,
        ]);
    }

    public function test_encadrant_can_filter_stages_by_status(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $activeStage = $this->createStage(
            $encadrant,
            'en_cours',
            'Stage en cours'
        );

        $completedStage = $this->createStage(
            $encadrant,
            'termine',
            'Stage terminé'
        );

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stages.index', [
                'statut' => 'en_cours',
            ]));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Stagiaires/Index')
            ->has('stages.data', 1)
            ->where('filters.statut', 'en_cours')
            ->where('stages.data.0.id', $activeStage->id)
        );

        $this->assertNotEquals($activeStage->id, $completedStage->id);
    }

    public function test_encadrant_can_search_stage_by_subject(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $matchingStage = $this->createStage(
            $encadrant,
            'en_cours',
            'Plateforme InternHub'
        );

        $this->createStage(
            $encadrant,
            'en_cours',
            'Application Mobile'
        );

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stages.index', [
                'search' => 'InternHub',
            ]));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Stagiaires/Index')
            ->has('stages.data', 1)
            ->where('filters.search', 'InternHub')
            ->where('stages.data.0.id', $matchingStage->id)
        );
    }

    public function test_encadrant_can_search_stage_by_stagiaire_name(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $entrepriseUser = User::where('role', 'Entreprise')->first();

        $offre = Offredestage::create([
            'titre' => 'Stage personnalisé',
            'description' => 'Stage de recherche',
            'duree' => '4 mois',
            'date_limite' => now()->addMonth()->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entrepriseUser->id,
        ]);

        $candidature = Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Motivation',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offre->id,
        ]);

        $stage = Stage::create([
            'sujet' => 'Stage recherche par nom',
            'date_debut' => now()->subDays(5)->toDateString(),
            'date_fin' => now()->addMonths(3)->toDateString(),
            'statut' => 'en_cours',
            'idUtilisateur_Encadrant' => $encadrant->user_id,
            'id_Candidature' => $candidature->id,
        ]);

        $stagiaireUser->update([
            'nom_complet' => 'Mohamed Test Stagiaire',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stages.index', [
                'search' => 'Mohamed Test',
            ]));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Stagiaires/Index')
            ->has('stages.data', 1)
            ->where('filters.search', 'Mohamed Test')
            ->where('stages.data.0.id', $stage->id)
        );
    }

    public function test_encadrant_can_view_stage_details(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant,
            'en_cours',
            'Projet détail'
        );

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stages.show', $stage->id));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->where('stage.id', $stage->id)
            ->where('stage.sujet', 'Projet détail')
            ->where('stage.statut', 'en_cours')
            ->has('stage.candidature')
        );
    }

    public function test_encadrant_cannot_view_another_encadrants_stage_details(): void
    {
        [$user1, $encadrant1] = $this->createEncadrant();
        [, $encadrant2] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant2,
            'en_cours',
            'Stage privé'
        );

        $response = $this
            ->actingAs($user1)
            ->get(route('encadrant.stages.show', $stage->id));

        $response->assertNotFound();
    }

    public function test_encadrant_can_update_own_stage(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant,
            'en_cours',
            'Ancien sujet'
        );

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.stages.update', $stage->id), [
                'sujet' => 'Nouveau sujet',
                'date_debut' => '2026-09-01',
                'date_fin' => '2026-12-01',
                'statut' => 'en_cours',
            ]);

        $response->assertSessionHas(
            'message',
            'Le stage a été mis à jour avec succès.'
        );

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'sujet' => 'Nouveau sujet',
            'date_debut' => '2026-09-01',
            'date_fin' => '2026-12-01',
            'statut' => 'en_cours',
        ]);
    }

    public function test_encadrant_cannot_update_another_encadrants_stage(): void
    {
        [$user1, $encadrant1] = $this->createEncadrant();
        [, $encadrant2] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant2,
            'en_cours',
            'Sujet original'
        );

        $response = $this
            ->actingAs($user1)
            ->put(route('encadrant.stages.update', $stage->id), [
                'sujet' => 'Sujet modifié',
                'date_debut' => '2026-09-01',
                'date_fin' => '2026-12-01',
                'statut' => 'en_cours',
            ]);

        $response->assertNotFound();

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'sujet' => 'Sujet original',
        ]);
    }

    public function test_stage_update_validates_dates(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.stages.update', $stage->id), [
                'sujet' => 'Sujet invalide',
                'date_debut' => '2026-12-01',
                'date_fin' => '2026-09-01',
                'statut' => 'en_cours',
            ]);

        $response->assertSessionHasErrors('date_fin');
    }

    public function test_stage_update_validates_status(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.stages.update', $stage->id), [
                'sujet' => 'Sujet',
                'date_debut' => '2026-09-01',
                'date_fin' => '2026-12-01',
                'statut' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors('statut');
    }

    public function test_encadrant_can_update_stage_status(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant,
            'en_cours'
        );

        $response = $this
            ->actingAs($user)
            ->patch(route('encadrant.stages.updateStatus', $stage->id), [
                'statut' => 'termine',
            ]);

        $response->assertSessionHas(
            'message',
            'Statut du stage mis à jour.'
        );

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'statut' => 'termine',
        ]);
    }

    public function test_encadrant_cannot_update_status_of_another_encadrants_stage(): void
    {
        [$user1, $encadrant1] = $this->createEncadrant();
        [, $encadrant2] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant2,
            'en_cours'
        );

        $response = $this
            ->actingAs($user1)
            ->patch(route('encadrant.stages.updateStatus', $stage->id), [
                'statut' => 'termine',
            ]);

        $response->assertNotFound();

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'statut' => 'en_cours',
        ]);
    }

    public function test_stage_status_update_validates_status(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage($encadrant);

        $response = $this
            ->actingAs($user)
            ->patch(route('encadrant.stages.updateStatus', $stage->id), [
                'statut' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors('statut');
    }

    public function test_encadrant_can_view_stagiaire_details(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant,
            'en_cours',
            'Stage stagiaire'
        );

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stagiaires.show', $stage->id));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Stagiaires/Show')
            ->where('stage.id', $stage->id)
            ->where('stage.sujet', 'Stage stagiaire')
            ->has('stage.candidature.stagiaire.user')
        );
    }

    public function test_encadrant_cannot_view_another_encadrants_stagiaire_details(): void
    {
        [$user1, $encadrant1] = $this->createEncadrant();
        [, $encadrant2] = $this->createEncadrant();

        $stage = $this->createStage(
            $encadrant2,
            'en_cours'
        );

        $response = $this
            ->actingAs($user1)
            ->get(route('encadrant.stagiaires.show', $stage->id));

        $response->assertNotFound();
    }

    public function test_guest_cannot_access_encadrant_stages(): void
    {
        $response = $this->get(route('encadrant.stages.index'));

        $response->assertRedirect();
    }

    public function test_non_encadrant_cannot_access_encadrant_stages(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.stages.index'));

        $response->assertForbidden();
    }
}