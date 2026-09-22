<?php

namespace Tests\Feature\Encadrant;

use App\Models\Encadrant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createEncadrant(array $userData = [], array $encadrantData = []): array
    {
        $user = User::factory()->create(array_merge([
            'role' => 'Encadrant',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password123'),
        ], $userData));

        $encadrant = Encadrant::create(array_merge([
            'user_id' => $user->id,
            'poste' => 'Encadrant',
            'specialite' => 'Développement Web',
            'departement' => 'Informatique',
        ], $encadrantData));

        return [$user, $encadrant];
    }

    public function test_encadrant_can_view_own_profile(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.profile.edit'));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Profile/Edit')
            ->where('user.id', $user->id)
            ->where('user.nom_complet', $user->nom_complet)
            ->where('user.email', $user->email)
            ->where('user.telephone', $user->telephone)
            ->where('user.role', 'Encadrant')
            ->where('encadrant.user_id', $encadrant->user_id)
            ->where('encadrant.poste', $encadrant->poste)
            ->where('encadrant.specialite', $encadrant->specialite)
            ->where('encadrant.departement', $encadrant->departement)
        );
    }

    public function test_encadrant_profile_returns_null_when_encadrant_record_does_not_exist(): void
    {
        $user = User::factory()->create([
            'role' => 'Encadrant',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.profile.edit'));

        $response->assertSuccessful();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Encadrant/Profile/Edit')
            ->where('user.id', $user->id)
            ->where('user.role', 'Encadrant')
            ->where('encadrant', null)
        );
    }

    public function test_encadrant_can_update_own_profile(): void
    {
        [$user, $encadrant] = $this->createEncadrant();

        $response = $this
            ->actingAs($user)
            ->patch(route('encadrant.profile.update'), [
                'nom_complet' => 'Nouveau Nom',
                'email' => 'nouveau@example.com',
                'telephone' => '0612345678',
                'poste' => 'Senior Encadrant',
                'specialite' => 'Laravel',
                'departement' => 'Développement',
            ]);

        $response
            ->assertRedirect(route('encadrant.profile.edit'))
            ->assertSessionHas('message', 'Profile updated successfully.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nom_complet' => 'Nouveau Nom',
            'email' => 'nouveau@example.com',
            'telephone' => '0612345678',
        ]);

        $this->assertDatabaseHas('encadrants', [
            'user_id' => $encadrant->user_id,
            'poste' => 'Senior Encadrant',
            'specialite' => 'Laravel',
            'departement' => 'Développement',
        ]);
    }

    public function test_encadrant_can_keep_the_same_email(): void
    {
        [$user] = $this->createEncadrant();

        $response = $this
            ->actingAs($user)
            ->patch(route('encadrant.profile.update'), [
                'nom_complet' => 'Nom Modifié',
                'email' => $user->email,
                'telephone' => '0600000000',
                'poste' => 'Encadrant',
                'specialite' => 'PHP',
                'departement' => 'IT',
            ]);

        $response->assertRedirect(route('encadrant.profile.edit'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'nom_complet' => 'Nom Modifié',
        ]);
    }

    public function test_encadrant_cannot_use_an_email_already_used_by_another_user(): void
    {
        [$user] = $this->createEncadrant();

        $otherUser = User::factory()->create([
            'role' => 'Encadrant',
            'email' => 'existing@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('encadrant.profile.update'), [
                'nom_complet' => 'Nom Modifié',
                'email' => $otherUser->email,
                'telephone' => null,
                'poste' => null,
                'specialite' => null,
                'departement' => null,
            ]);

        $response->assertSessionHasErrors('email');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function test_encadrant_profile_requires_name_and_email(): void
    {
        [$user] = $this->createEncadrant();

        $response = $this
            ->actingAs($user)
            ->patch(route('encadrant.profile.update'), [
                'nom_complet' => '',
                'email' => '',
            ]);

        $response->assertSessionHasErrors([
            'nom_complet',
            'email',
        ]);
    }

    public function test_encadrant_can_update_password_with_correct_current_password(): void
    {
        [$user] = $this->createEncadrant([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.profile.password'), [
                'current_password' => 'oldpassword123',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response
            ->assertRedirect(route('encadrant.profile.edit'))
            ->assertSessionHas('message', 'Password updated successfully.');

        $user->refresh();

        $this->assertTrue(
            Hash::check('newpassword123', $user->password)
        );

        $this->assertFalse(
            Hash::check('oldpassword123', $user->password)
        );
    }

    public function test_encadrant_cannot_update_password_with_wrong_current_password(): void
    {
        [$user] = $this->createEncadrant([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.profile.password'), [
                'current_password' => 'wrongpassword',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertSessionHasErrors('current_password');

        $user->refresh();

        $this->assertTrue(
            Hash::check('oldpassword123', $user->password)
        );
    }

    public function test_encadrant_password_must_have_at_least_eight_characters(): void
    {
        [$user] = $this->createEncadrant([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.profile.password'), [
                'current_password' => 'oldpassword123',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

        $response->assertSessionHasErrors('password');

        $user->refresh();

        $this->assertTrue(
            Hash::check('oldpassword123', $user->password)
        );
    }

    public function test_encadrant_password_confirmation_is_required(): void
    {
        [$user] = $this->createEncadrant([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('encadrant.profile.password'), [
                'current_password' => 'oldpassword123',
                'password' => 'newpassword123',
            ]);

        $response->assertSessionHasErrors('password');

        $user->refresh();

        $this->assertTrue(
            Hash::check('oldpassword123', $user->password)
        );
    }

    public function test_guest_cannot_access_encadrant_profile(): void
    {
        $response = $this->get(route('encadrant.profile.edit'));

        $response->assertRedirect();
    }

    public function test_non_encadrant_cannot_access_encadrant_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('encadrant.profile.edit'));

        $response->assertForbidden();
    }
}