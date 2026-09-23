<?php

namespace Tests\Feature\Entreprise;

use App\Models\Candidature;
use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidatureTest extends TestCase
{
    use RefreshDatabase;

    private function createEntreprise(): array
    {
        $user = User::factory()->create([
            'role' => 'Entreprise',
            'etat' => 'active',
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $user->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tanger',
        ]);

        return [$user, $entreprise];
    }

    private function createStagiaire(): array
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'etat' => 'active',
        ]);

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
        ]);

        return [$user, $stagiaire];
    }

    private function createOffer(int $entrepriseId, array $attributes = []): Offredestage
    {
        return Offredestage::create(array_merge([
            'titre' => 'Développeur Laravel',
            'description' => 'Développement d une application web avec Laravel.',
            'duree' => '3 mois',
            'date_limite' => now()->addDays(30)->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entrepriseId,
        ], $attributes));
    }

    private function createCandidature(
        int $stagiaireId,
        int $offerId,
        array $attributes = []
    ): Candidature {
        return Candidature::create(array_merge([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite rejoindre votre entreprise.',
            'cv_url' => 'cvs/test-cv.pdf',
            'idUtilisateur_Stagiaire' => $stagiaireId,
            'id_Offre_De_Stage' => $offerId,
        ], $attributes));
    }

    public function test_entreprise_can_view_received_applications(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $offer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.candidatures.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Entreprise/Candidatures/Index')
                ->has('candidatures.data', 1)
                ->where('candidatures.data.0.id', $application->id)
                ->has('offres', 1)
                ->has('filters')
        );
    }

    public function test_entreprise_only_sees_applications_for_its_own_offers(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$otherEntrepriseUser] = $this->createEntreprise();

        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $ownOffer = $this->createOffer($entrepriseUser->id, [
            'titre' => 'Notre offre',
        ]);

        $otherOffer = $this->createOffer($otherEntrepriseUser->id, [
            'titre' => 'Offre autre entreprise',
        ]);

        $ownApplication = $this->createCandidature(
            $stagiaire->user_id,
            $ownOffer->id
        );

        // A second stagiaire is required because of the unique constraint.
        [$otherStagiaireUser, $otherStagiaire] = $this->createStagiaire();

        $otherApplication = $this->createCandidature(
            $otherStagiaire->user_id,
            $otherOffer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.candidatures.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('candidatures.data', 1)
                ->where('candidatures.data.0.id', $ownApplication->id)
                ->where('candidatures.data.0.id', fn ($id) =>
                    $id !== $otherApplication->id
                )
        );
    }

    public function test_entreprise_can_filter_applications_by_status(): void
    {
        [$entrepriseUser] = $this->createEntreprise();

        [$stagiaireUser1, $stagiaire1] = $this->createStagiaire();
        [$stagiaireUser2, $stagiaire2] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $accepted = $this->createCandidature(
            $stagiaire1->user_id,
            $offer->id,
            ['statut' => 'acceptee']
        );

        $pending = $this->createCandidature(
            $stagiaire2->user_id,
            $offer->id,
            ['statut' => 'en_attente']
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.candidatures.index', [
                'statut' => 'acceptee',
            ]));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('candidatures.data', 1)
                ->where('candidatures.data.0.id', $accepted->id)
                ->where('filters.statut', 'acceptee')
        );

        $this->assertNotSame($accepted->id, $pending->id);
    }

    public function test_entreprise_can_filter_applications_by_offer(): void
    {
        [$entrepriseUser] = $this->createEntreprise();

        [$stagiaireUser1, $stagiaire1] = $this->createStagiaire();
        [$stagiaireUser2, $stagiaire2] = $this->createStagiaire();

        $offer1 = $this->createOffer($entrepriseUser->id, [
            'titre' => 'Laravel',
        ]);

        $offer2 = $this->createOffer($entrepriseUser->id, [
            'titre' => 'Vue.js',
        ]);

        $application1 = $this->createCandidature(
            $stagiaire1->user_id,
            $offer1->id
        );

        $application2 = $this->createCandidature(
            $stagiaire2->user_id,
            $offer2->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.candidatures.index', [
                'offre_id' => $offer1->id,
            ]));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('candidatures.data', 1)
                ->where('candidatures.data.0.id', $application1->id)
                ->where('filters.offre_id', (string) $offer1->id)
        );

        $this->assertNotSame($application1->id, $application2->id);
    }

    public function test_entreprise_can_view_application_details(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $offer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.candidatures.show', $application->id));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Entreprise/Candidatures/Show')
                ->where('candidature.id', $application->id)
                ->where(
                    'candidature.id_Offre_De_Stage',
                    $offer->id
                )
        );
    }

    public function test_entreprise_cannot_view_application_from_another_entreprise(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$otherEntrepriseUser] = $this->createEntreprise();

        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $otherOffer = $this->createOffer($otherEntrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $otherOffer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.candidatures.show', $application->id));

        $response->assertNotFound();
    }

    public function test_entreprise_can_update_application_status(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $offer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->patch(
                route(
                    'entreprise.candidatures.updateStatus',
                    $application->id
                ),
                [
                    'statut' => 'acceptee',
                ]
            );

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('candidatures', [
            'id' => $application->id,
            'statut' => 'acceptee',
        ]);
    }

    public function test_entreprise_cannot_update_application_from_another_entreprise(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$otherEntrepriseUser] = $this->createEntreprise();

        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $otherOffer = $this->createOffer($otherEntrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $otherOffer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->patch(
                route(
                    'entreprise.candidatures.updateStatus',
                    $application->id
                ),
                [
                    'statut' => 'acceptee',
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('candidatures', [
            'id' => $application->id,
            'statut' => 'en_attente',
        ]);
    }

    public function test_entreprise_cannot_update_application_with_invalid_status(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $offer->id
        );

        $response = $this->actingAs($entrepriseUser)
            ->patch(
                route(
                    'entreprise.candidatures.updateStatus',
                    $application->id
                ),
                [
                    'statut' => 'invalid',
                ]
            );

        $response->assertSessionHasErrors([
            'statut',
        ]);

        $this->assertDatabaseHas('candidatures', [
            'id' => $application->id,
            'statut' => 'en_attente',
        ]);
    }

    public function test_entreprise_can_view_accepted_students(): void
    {
        [$entrepriseUser] = $this->createEntreprise();

        [$stagiaireUser1, $stagiaire1] = $this->createStagiaire();
        [$stagiaireUser2, $stagiaire2] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $accepted = $this->createCandidature(
            $stagiaire1->user_id,
            $offer->id,
            ['statut' => 'acceptee']
        );

        $pending = $this->createCandidature(
            $stagiaire2->user_id,
            $offer->id,
            ['statut' => 'en_attente']
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.acceptedStudents.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('acceptedStudents.data', 1)
                ->where('acceptedStudents.data.0.id', $accepted->id)
        );

        $this->assertNotSame($accepted->id, $pending->id);
    }

    public function test_entreprise_can_filter_accepted_students_by_offer(): void
    {
        [$entrepriseUser] = $this->createEntreprise();

        [$stagiaireUser1, $stagiaire1] = $this->createStagiaire();
        [$stagiaireUser2, $stagiaire2] = $this->createStagiaire();

        $offer1 = $this->createOffer($entrepriseUser->id);
        $offer2 = $this->createOffer($entrepriseUser->id);

        $accepted1 = $this->createCandidature(
            $stagiaire1->user_id,
            $offer1->id,
            ['statut' => 'acceptee']
        );

        $accepted2 = $this->createCandidature(
            $stagiaire2->user_id,
            $offer2->id,
            ['statut' => 'acceptee']
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route('entreprise.acceptedStudents.index', [
                'offre_id' => $offer1->id,
            ]));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->has('acceptedStudents.data', 1)
                ->where('acceptedStudents.data.0.id', $accepted1->id)
        );

        $this->assertNotSame($accepted1->id, $accepted2->id);
    }

    public function test_entreprise_can_view_accepted_student_details(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer($entrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $offer->id,
            ['statut' => 'acceptee']
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route(
                'entreprise.acceptedStudents.show',
                $application->id
            ));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Entreprise/AcceptedStudents/Show')
                ->where('candidature.id', $application->id)
                ->where('candidature.statut', 'acceptee')
                ->has('encadrants')
        );
    }

    public function test_entreprise_cannot_view_accepted_student_from_another_entreprise(): void
    {
        [$entrepriseUser] = $this->createEntreprise();
        [$otherEntrepriseUser] = $this->createEntreprise();

        [$stagiaireUser, $stagiaire] = $this->createStagiaire();

        $otherOffer = $this->createOffer($otherEntrepriseUser->id);

        $application = $this->createCandidature(
            $stagiaire->user_id,
            $otherOffer->id,
            ['statut' => 'acceptee']
        );

        $response = $this->actingAs($entrepriseUser)
            ->get(route(
                'entreprise.acceptedStudents.show',
                $application->id
            ));

        $response->assertNotFound();
    }
}
