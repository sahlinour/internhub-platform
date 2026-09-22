<?php

namespace Tests\Feature\Entreprise;

use App\Models\Candidature;
use App\Models\Entreprise;
use App\Models\Encadrant;
use App\Models\Offredestage;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StageTest extends TestCase
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
        Offredestage $offre,
        string $statut = 'acceptee'
    ): Candidature {
        return Candidature::create([
            'statut' => $statut,
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
        ?User $encadrant = null,
        string $statut = 'en_cours'
    ): Stage {
        return Stage::create([
            'sujet' => 'Développement de la plateforme InternHub',
            'date_debut' => now()->addDay()->toDateString(),
            'date_fin' => now()->addMonths(3)->toDateString(),
            'statut' => $statut,
            'idUtilisateur_Encadrant' => $encadrant?->id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    public function test_entreprise_can_view_its_current_internships(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);

        $stage = $this->createStage($candidature);

        $this->actingAs($entreprise)
            ->get(route('entreprise.stages.index'))
            ->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->component('Entreprise/Stages/Index')
                    ->has('stages.data', 1)
                    ->where('stages.data.0.id', $stage->id)
            );
    }

    public function test_entreprise_only_sees_current_internships_from_its_own_company(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($otherEntreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1)
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2)
        );

        $this->actingAs($entreprise)
            ->get(route('entreprise.stages.index'))
            ->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->component('Entreprise/Stages/Index')
                    ->has('stages.data', 1)
                    ->where('stages.data.0.id', $stage1->id)
                    ->where('stages.data.0.id', fn ($id) => $id !== $stage2->id)
            );
    }

    public function test_entreprise_does_not_see_completed_or_cancelled_internships(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();
        $stagiaire3 = $this->createStagiaire();

        $offre = $this->createOffer($entreprise);

        $current = $this->createStage(
            $this->createCandidature($stagiaire1, $offre),
            null,
            'en_cours'
        );

        $completed = $this->createStage(
            $this->createCandidature($stagiaire2, $offre),
            null,
            'termine'
        );

        $cancelled = $this->createStage(
            $this->createCandidature($stagiaire3, $offre),
            null,
            'annule'
        );

        $this->actingAs($entreprise)
            ->get(route('entreprise.stages.index'))
            ->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('stages.data', 1)
                    ->where('stages.data.0.id', $current->id)
            );
    }

    public function test_entreprise_can_create_internship_from_accepted_application(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.stages.store'), [
                'sujet' => 'Développement Laravel',
                'date_debut' => '2026-10-01',
                'date_fin' => '2026-12-31',
                'id_Candidature' => $candidature->id,
            ]);

        $response->assertSessionHas(
            'message',
            'Internship successfully created.'
        );

        $this->assertDatabaseHas('stages', [
            'id_Candidature' => $candidature->id,
            'sujet' => 'Développement Laravel',
            'statut' => 'en_cours',
        ]);
    }

    public function test_entreprise_cannot_create_internship_from_non_accepted_application(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $offre = $this->createOffer($entreprise);

        $candidature = $this->createCandidature(
            $stagiaire,
            $offre,
            'en_attente'
        );

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.stages.store'), [
                'sujet' => 'Développement Laravel',
                'date_debut' => '2026-10-01',
                'date_fin' => '2026-12-31',
                'id_Candidature' => $candidature->id,
            ]);

        $response->assertSessionHas(
            'error',
            'The application must be accepted before creating an internship.'
        );

        $this->assertDatabaseMissing('stages', [
            'id_Candidature' => $candidature->id,
        ]);
    }

    public function test_entreprise_cannot_create_internship_for_another_company_application(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire = $this->createStagiaire();

        $otherOffer = $this->createOffer($otherEntreprise);
        $candidature = $this->createCandidature(
            $stagiaire,
            $otherOffer
        );

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.stages.store'), [
                'sujet' => 'Unauthorized internship',
                'date_debut' => '2026-10-01',
                'date_fin' => '2026-12-31',
                'id_Candidature' => $candidature->id,
            ]);

        $response->assertNotFound();

        $this->assertDatabaseMissing('stages', [
            'id_Candidature' => $candidature->id,
        ]);
    }

    public function test_entreprise_cannot_create_two_internships_for_same_application(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);

        $this->createStage($candidature);

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.stages.store'), [
                'sujet' => 'Second internship',
                'date_debut' => '2026-10-01',
                'date_fin' => '2026-12-31',
                'id_Candidature' => $candidature->id,
            ]);

        $response->assertSessionHas(
            'error',
            'An internship has already been created for this application.'
        );

        $this->assertDatabaseCount('stages', 1);
    }

    public function test_internship_dates_must_be_valid(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.stages.store'), [
                'sujet' => 'Invalid dates',
                'date_debut' => '2026-12-31',
                'date_fin' => '2026-10-01',
                'id_Candidature' => $candidature->id,
            ]);

        $response->assertSessionHasErrors('date_fin');

        $this->assertDatabaseMissing('stages', [
            'id_Candidature' => $candidature->id,
        ]);
    }

    public function test_entreprise_can_assign_its_own_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);
        $stage = $this->createStage($candidature);

        $response = $this->actingAs($entreprise)
            ->patch(
                route('entreprise.stages.assignEncadrant', $stage->id),
                [
                    'idUtilisateur_Encadrant' => $encadrant->id,
                ]
            );

        $response->assertSessionHas(
            'message',
            'Supervisor assigned successfully.'
        );

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'idUtilisateur_Encadrant' => $encadrant->id,
        ]);
    }

    public function test_entreprise_cannot_assign_supervisor_from_another_company(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($otherEntreprise);

        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);
        $stage = $this->createStage($candidature);

        $response = $this->actingAs($entreprise)
            ->patch(
                route('entreprise.stages.assignEncadrant', $stage->id),
                [
                    'idUtilisateur_Encadrant' => $encadrant->id,
                ]
            );

        $response->assertSessionHasErrors(
            'idUtilisateur_Encadrant'
        );

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'idUtilisateur_Encadrant' => null,
        ]);
    }

    public function test_entreprise_cannot_assign_supervisor_to_another_company_stage(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $otherOffer = $this->createOffer($otherEntreprise);
        $otherCandidature = $this->createCandidature(
            $stagiaire,
            $otherOffer
        );
        $otherStage = $this->createStage($otherCandidature);

        $response = $this->actingAs($entreprise)
            ->patch(
                route(
                    'entreprise.stages.assignEncadrant',
                    $otherStage->id
                ),
                [
                    'idUtilisateur_Encadrant' => $encadrant->id,
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('stages', [
            'id' => $otherStage->id,
            'idUtilisateur_Encadrant' => null,
        ]);
    }

    public function test_entreprise_can_delete_its_internship(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature($stagiaire, $offre);

        $stage = $this->createStage($candidature);

        $response = $this->actingAs($entreprise)
            ->delete(
                route('entreprise.stages.destroy', $stage->id)
            );

        $response->assertSessionHas(
            'message',
            'Internship deleted successfully.'
        );

        $this->assertSoftDeleted('stages', [
            'id' => $stage->id,
        ]);
    }

    public function test_entreprise_cannot_delete_another_company_internship(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire = $this->createStagiaire();

        $otherOffer = $this->createOffer($otherEntreprise);
        $otherCandidature = $this->createCandidature(
            $stagiaire,
            $otherOffer
        );
        $otherStage = $this->createStage($otherCandidature);

        $response = $this->actingAs($entreprise)
            ->delete(
                route(
                    'entreprise.stages.destroy',
                    $otherStage->id
                )
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('stages', [
            'id' => $otherStage->id,
            'deleted_at' => null,
        ]);
    }
}
