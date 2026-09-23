<?php

namespace Tests\Feature\Stagiaire;

use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StagiaireProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_stagiaire_can_view_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.profile.show'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_can_view_profile_edit_page(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.profile.edit'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_can_update_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $ville = Ville::create(['nom' => 'Tanger',]);

        $response = $this->actingAs($user)
            ->put(route('stagiaire.profile.update'), [
                'nom_complet' => 'Nouveau Stagiaire',
                'email' => 'nouveau@example.com',
                'telephone' => '0612345678',
                'ville_id' => $ville->id,
                'universite' => 'Université Mohammed V',
                'filiere' => 'Data Science',
                'niveau' => 'Bac+4',
                'date_naissance' => '2005-02-10',
                'linkedin_url' => 'https://www.linkedin.com/in/test',
                'portfolio_url' => 'https://example.com',
                'statut_stage' => 'recherche',
            ]);

        $response->assertRedirect(route('stagiaire.profile.show'));

        $user->refresh();
        $stagiaire = $user->stagiaire;

        $this->assertSame('Nouveau Stagiaire', $user->nom_complet);
        $this->assertSame('nouveau@example.com', $user->email);
        $this->assertSame('0612345678', $user->telephone);
        $this->assertSame($ville->id, $user->ville_id);

        $this->assertSame('Université Mohammed V', $stagiaire->universite);
        $this->assertSame('Data Science', $stagiaire->filiere);
        $this->assertSame('Bac+4', $stagiaire->niveau);
        $this->assertSame('2005-02-10', $stagiaire->date_naissance);
        $this->assertSame('https://www.linkedin.com/in/test', $stagiaire->linkedin_url);
        $this->assertSame('https://example.com', $stagiaire->portfolio_url);
        $this->assertSame('recherche', $stagiaire->statut_stage);
    }

    public function test_stagiaire_profile_requires_valid_ville(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->put(route('stagiaire.profile.update'), [
                'nom_complet' => 'Test Stagiaire',
                'email' => 'test@example.com',
                'ville_id' => 999999,
            ]);

        $response->assertSessionHasErrors('ville_id');
    }

    public function test_stagiaire_can_update_password(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)
            ->put(route('stagiaire.profile.password.update'), [
                'current_password' => 'old-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertTrue(
            Hash::check('new-password', $user->password)
        );
    }

    public function test_stagiaire_cannot_update_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)
            ->put(route('stagiaire.profile.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertSessionHasErrors('current_password');

        $user->refresh();

        $this->assertTrue(
            Hash::check('old-password', $user->password)
        );
    }

    public function test_stagiaire_can_delete_account_with_correct_password(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'password' => Hash::make('password'),
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('stagiaire.profile.destroy'), [
                'password' => 'password',
            ]);

        $response->assertRedirect('/');

        $this->assertGuest();

        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
    }

    public function test_stagiaire_cannot_delete_account_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
            'password' => Hash::make('password'),
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('stagiaire.profile.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors('password');

        $this->assertAuthenticatedAs($user);
    }
}