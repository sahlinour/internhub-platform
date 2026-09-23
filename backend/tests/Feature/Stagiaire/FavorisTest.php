<?php

namespace Tests\Feature\Stagiaire;

use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavorisTest extends TestCase
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

    private function createOffer(): Offredestage
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
            'statut' => 'active',
            'idUtilisateur_Entreprise' => $entreprise->user_id,
        ]);
    }

    public function test_stagiaire_can_view_favorites(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $stagiaire->favoris()->attach($offer->id);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.favoris.index'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_can_add_offer_to_favorites(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $response = $this->actingAs($user)
            ->post(route('stagiaire.favoris.toggle', $offer->id));

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('favoris', [
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);
    }

    public function test_stagiaire_can_toggle_favorite_off(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $stagiaire->favoris()->attach($offer->id);

        $response = $this->actingAs($user)
            ->post(route('stagiaire.favoris.toggle', $offer->id));

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('favoris', [
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);
    }

    public function test_stagiaire_can_remove_favorite_directly(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $offer = $this->createOffer();

        $stagiaire->favoris()->attach($offer->id);

        $response = $this->actingAs($user)
            ->delete(route('stagiaire.favoris.destroy', $offer->id));

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('favoris', [
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);
    }

    public function test_stagiaire_cannot_favorite_non_existing_offer(): void
    {
        [$user] = $this->createStagiaire();

        $response = $this->actingAs($user)
            ->post(route('stagiaire.favoris.toggle', 999999));

        $response->assertNotFound();
    }
}