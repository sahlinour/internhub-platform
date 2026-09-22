<?php

namespace Tests\Feature\Stagiaire;

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

    private function createOffer(string $statut = 'ouverte'): Offredestage
    {
        $user = User::factory()->create([
            'role' => 'Entreprise',
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $user->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tanger',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de test',
        ]);

        return Offredestage::create([
            'titre' => 'Stage Laravel',
            'description' => 'Stage de développement Laravel',
            'duree' => '3 mois',
            'date_limite' => '2026-12-31',
            'statut' => $statut,
            'idUtilisateur_Entreprise' => $entreprise->user_id,
        ]);
    }

    public function test_stagiaire_can_view_applications(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        Candidature::create([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite rejoindre votre entreprise.',
            'cv_url' => 'cvs/test.pdf',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.candidatures.index'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_can_view_application_form_for_open_offer(): void
    {
        [$user] = $this->createStagiaire();

        $offer = $this->createOffer('ouverte');

        $response = $this->actingAs($user)
            ->get(route('stagiaire.candidatures.create', $offer->id));

        $response->assertStatus(200);
    }

    public function test_stagiaire_cannot_apply_to_closed_offer_form(): void
    {
        [$user] = $this->createStagiaire();

        $offer = $this->createOffer('fermee');

        $response = $this->actingAs($user)
            ->get(route('stagiaire.candidatures.create', $offer->id));

        $response->assertNotFound();
    }

    public function test_stagiaire_can_submit_application(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $response = $this->actingAs($user)
            ->post(route('stagiaire.candidatures.store', $offer->id), [
                'lettre_de_motivation' => 'Je suis très motivé pour ce stage.',
            ]);

        $candidature = Candidature::first();

        $response->assertRedirect(
            route('stagiaire.candidatures.show', $candidature->id)
        );

        $this->assertDatabaseHas('candidatures', [
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
            'statut' => 'en_attente',
            'lettre_de_motivation' => 'Je suis très motivé pour ce stage.',
        ]);
    }

    public function test_stagiaire_cannot_apply_twice_to_same_offer(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        Candidature::create([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Première candidature.',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('stagiaire.candidatures.store', $offer->id), [
                'lettre_de_motivation' => 'Deuxième candidature.',
            ]);

        $response->assertSessionHas('error', 'You have already applied to this offer.');

        $this->assertSame(
            1,
            Candidature::where('idUtilisateur_Stagiaire', $stagiaire->user_id)
                ->where('id_Offre_De_Stage', $offer->id)
                ->count()
        );
    }

    public function test_stagiaire_can_view_own_application(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $candidature = Candidature::create([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Ma lettre de motivation.',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.candidatures.show', $candidature->id));

        $response->assertStatus(200);
    }

    public function test_stagiaire_cannot_view_another_stagiaire_application(): void
    {
        [$user1, $stagiaire1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $offer = $this->createOffer();

        $candidature = Candidature::create([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Candidature privée.',
            'idUtilisateur_Stagiaire' => $stagiaire2->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        $response = $this->actingAs($user1)
            ->get(route('stagiaire.candidatures.show', $candidature->id));

        $response->assertNotFound();
    }

    public function test_stagiaire_can_withdraw_own_application(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $candidature = Candidature::create([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite effectuer ce stage.',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('stagiaire.candidatures.destroy', $candidature->id));

        $response->assertSessionHas(
            'message',
            'Application withdrawn successfully.'
        );

        $this->assertSoftDeleted('candidatures', [
            'id' => $candidature->id,
        ]);
    }

    public function test_stagiaire_cannot_withdraw_another_stagiaire_application(): void
    {
        [$user1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $offer = $this->createOffer();

        $candidature = Candidature::create([
            'statut' => 'en_attente',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Candidature privée.',
            'idUtilisateur_Stagiaire' => $stagiaire2->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        $response = $this->actingAs($user1)
            ->delete(route('stagiaire.candidatures.destroy', $candidature->id));

        $response->assertNotFound();

        $this->assertDatabaseHas('candidatures', [
            'id' => $candidature->id,
        ]);
    }

    public function test_application_requires_valid_file_types(): void
    {
        [$user] = $this->createStagiaire();

        $offer = $this->createOffer();

        $response = $this->actingAs($user)
            ->post(route('stagiaire.candidatures.store', $offer->id), [
                'lettre_de_motivation' => 'Test',
                'cv' => 'not-a-valid-file.txt',
            ]);

        $response->assertSessionHasErrors('cv');
    }
}