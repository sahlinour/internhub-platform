<?php

namespace Tests\Feature\Entreprise;

use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OffreDeStageTest extends TestCase
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
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de développement informatique.',
        ]);

        return [$user, $entreprise];
    }

    private function createOffer(int $entrepriseId, array $attributes = []): Offredestage
    {
        return Offredestage::create(array_merge([
            'titre' => 'Développeur Laravel Junior',
            'description' => 'Développement d applications web avec Laravel.',
            'duree' => '3 mois',
            'date_limite' => now()->addDays(30)->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entrepriseId,
        ], $attributes));
    }

    public function test_entreprise_can_view_its_offers(): void
    {
        [$user] = $this->createEntreprise();

        $offer1 = $this->createOffer($user->id, [
            'titre' => 'Développeur Laravel',
        ]);

        $offer2 = $this->createOffer($user->id, [
            'titre' => 'Développeur Vue.js',
        ]);

        $otherUser = User::factory()->create([
            'role' => 'Entreprise',
            'etat' => 'active',
        ]);

        Entreprise::create([
            'user_id' => $otherUser->id,
            'secteur' => 'Informatique',
            'adresse' => 'Casablanca',
        ]);

        $otherOffer = $this->createOffer($otherUser->id, [
            'titre' => 'Offre autre entreprise',
        ]);

        $response = $this->actingAs($user)
            ->get(route('entreprise.offres.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Entreprise/Offres/Index')
                ->has('offres', 2)
                ->where('offres', fn ($offres) =>
                    $offres->pluck('id')->contains($offer1->id)
                    && $offres->pluck('id')->contains($offer2->id)
                    && ! $offres->pluck('id')->contains($otherOffer->id)
                )
        );
    }

    public function test_entreprise_can_view_create_offer_page(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->get(route('entreprise.offres.create'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page->component('Entreprise/Offres/Create')
        );
    }

    public function test_entreprise_can_create_offer(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->post(route('entreprise.offres.store'), [
                'titre' => 'Développeur Full Stack',
                'description' => 'Développement d une application web.',
                'duree' => '6 mois',
                'date_limite' => now()->addDays(30)->toDateString(),
                'statut' => 'ouverte',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('offredestages', [
            'titre' => 'Développeur Full Stack',
            'description' => 'Développement d une application web.',
            'duree' => '6 mois',
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $user->id,
        ]);
    }

    public function test_entreprise_cannot_create_offer_with_invalid_data(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->post(route('entreprise.offres.store'), [
                'titre' => '',
                'description' => '',
                'duree' => '',
                'date_limite' => now()->subDay()->toDateString(),
                'statut' => 'invalid',
            ]);

        $response->assertSessionHasErrors([
            'titre',
            'description',
            'duree',
            'date_limite',
            'statut',
        ]);

        $this->assertDatabaseCount('offredestages', 0);
    }

    public function test_entreprise_can_update_its_offer(): void
    {
        [$user] = $this->createEntreprise();

        $offer = $this->createOffer($user->id);

        $response = $this->actingAs($user)
            ->put(route('entreprise.offres.update', $offer->id), [
                'titre' => 'Développeur Laravel confirmé',
                'description' => 'Nouvelle description.',
                'duree' => '6 mois',
                'date_limite' => now()->addDays(60)->toDateString(),
                'statut' => 'active',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('offredestages', [
            'id' => $offer->id,
            'titre' => 'Développeur Laravel confirmé',
            'description' => 'Nouvelle description.',
            'duree' => '6 mois',
            'statut' => 'active',
        ]);
    }

    public function test_entreprise_cannot_update_another_entreprises_offer(): void
    {
        [$user1] = $this->createEntreprise();
        [$user2] = $this->createEntreprise();

        $offer = $this->createOffer($user2->id);

        $response = $this->actingAs($user1)
            ->put(route('entreprise.offres.update', $offer->id), [
                'titre' => 'Modification non autorisée',
                'description' => 'Tentative de modification.',
                'duree' => '6 mois',
                'date_limite' => now()->addDays(60)->toDateString(),
                'statut' => 'active',
            ]);

        $response->assertNotFound();

        $this->assertDatabaseHas('offredestages', [
            'id' => $offer->id,
            'titre' => 'Développeur Laravel Junior',
        ]);
    }

    public function test_entreprise_can_delete_its_offer(): void
    {
        [$user] = $this->createEntreprise();

        $offer = $this->createOffer($user->id);

        $response = $this->actingAs($user)
            ->delete(route('entreprise.offres.destroy', $offer->id));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertSoftDeleted('offredestages', [
            'id' => $offer->id,
        ]);
    }

    public function test_entreprise_cannot_delete_another_entreprises_offer(): void
    {
        [$user1] = $this->createEntreprise();
        [$user2] = $this->createEntreprise();

        $offer = $this->createOffer($user2->id);

        $response = $this->actingAs($user1)
            ->delete(route('entreprise.offres.destroy', $offer->id));

        $response->assertNotFound();

        $this->assertDatabaseHas('offredestages', [
            'id' => $offer->id,
            'deleted_at' => null,
        ]);
    }
}