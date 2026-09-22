<?php

namespace Tests\Feature\Entreprise;

use App\Models\Entreprise;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EntrepriseProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createEntreprise(): array
    {
        $ville = Ville::create([
            'nom' => 'Tanger',
        ]);

        $user = User::factory()->create([
            'role' => 'Entreprise',
            'etat' => 'active',
            'ville_id' => $ville->id,
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $user->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tanger',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de développement informatique.',
        ]);

        return [$user, $entreprise, $ville];
    }

    public function test_entreprise_can_view_profile(): void
    {
        [$user, $entreprise, $ville] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->get(route('entreprise.profile.show'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Entreprise/Profile/Show')
                ->has('entreprise')
                ->has('entreprise.entreprise')
                ->where('entreprise.id', $user->id)
                ->where('entreprise.nom_complet', $user->nom_complet)
                ->where('entreprise.entreprise.secteur', $entreprise->secteur)
                ->where('entreprise.entreprise.adresse', $entreprise->adresse)
                ->has('villes')
        );
    }

    public function test_entreprise_can_update_profile(): void
    {
        [$user, $entreprise] = $this->createEntreprise();

        $newVille = Ville::create([
            'nom' => 'Casablanca',
        ]);

        $response = $this->actingAs($user)
            ->put(route('entreprise.profile.update'), [
                'nom_complet' => 'Tech Maroc',
                'email' => 'contact@techmaroc.com',
                'telephone' => '0612345678',
                'ville_id' => $newVille->id,
                'secteur' => 'Développement Web',
                'adresse' => 'Casablanca',
                'site_web' => 'https://techmaroc.com',
                'description' => 'Entreprise spécialisée dans le développement web.',
            ]);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nom_complet' => 'Tech Maroc',
            'email' => 'contact@techmaroc.com',
            'telephone' => '0612345678',
            'ville_id' => $newVille->id,
        ]);

        $this->assertDatabaseHas('entreprises', [
            'user_id' => $user->id,
            'secteur' => 'Développement Web',
            'adresse' => 'Casablanca',
            'site_web' => 'https://techmaroc.com',
            'description' => 'Entreprise spécialisée dans le développement web.',
        ]);
    }

    public function test_entreprise_profile_requires_valid_data(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->put(route('entreprise.profile.update'), [
                'nom_complet' => '',
                'email' => 'invalid-email',
                'telephone' => str_repeat('1', 21),
                'ville_id' => 999999,
                'secteur' => '',
                'adresse' => '',
                'site_web' => 'not-a-url',
            ]);

        $response->assertSessionHasErrors([
            'nom_complet',
            'email',
            'telephone',
            'ville_id',
            'secteur',
            'adresse',
            'site_web',
        ]);
    }

    public function test_entreprise_can_update_profile_photo(): void
    {
        Storage::fake('public');

        [$user] = $this->createEntreprise();

        $photo = UploadedFile::fake()->create('company-logo.jpg',100,'image/jpeg');

        $response = $this->actingAs($user)
            ->put(route('entreprise.profile.update'), [
                'nom_complet' => $user->nom_complet,
                'email' => $user->email,
                'telephone' => '0612345678',
                'ville_id' => $user->ville_id,
                'secteur' => 'Informatique',
                'adresse' => 'Tanger',
                'site_web' => 'https://example.com',
                'description' => 'Entreprise de test.',
                'photo' => $photo,
            ]);

        $response->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertNotNull($user->photo);

        Storage::disk('public')->assertExists($user->photo);
    }

    public function test_entreprise_can_update_password(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->put(route('entreprise.profile.password.update'), [
                'current_password' => 'password',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect();

        $user->refresh();

        $this->assertTrue(
            Hash::check('NewPassword123!', $user->password)
        );
    }

    public function test_entreprise_cannot_update_password_with_wrong_current_password(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->put(route('entreprise.profile.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $response->assertSessionHasErrors([
            'current_password',
        ]);

        $user->refresh();

        $this->assertTrue(
            Hash::check('password', $user->password)
        );
    }

    public function test_entreprise_can_delete_account(): void
    {
        Storage::fake('public');

        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->delete(route('entreprise.profile.destroy'), [
                'password' => 'password',
            ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();

        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

        $this->assertDatabaseHas('entreprises', [
            'user_id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    public function test_entreprise_cannot_delete_account_with_wrong_password(): void
    {
        [$user] = $this->createEntreprise();

        $response = $this->actingAs($user)
            ->delete(route('entreprise.profile.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors([
            'password',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseHas('entreprises', [
            'user_id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}