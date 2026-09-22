<?php

namespace Tests\Feature\Entreprise;

use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EncadrantTest extends TestCase
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

    private function createVille(): Ville
    {
        return Ville::create([
            'nom' => 'Tangier',
        ]);
    }

    private function createEncadrant(
        User $entreprise,
        ?Ville $ville = null
    ): User {
        $ville ??= $this->createVille();

        $user = User::factory()->create([
            'role' => 'Encadrant',
            'etat' => 'active',
            'ville_id' => $ville->id,
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

    /** @test */
    public function test_entreprise_can_view_its_supervisors(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        $encadrant = $this->createEncadrant(
            $entreprise,
            $ville
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.encadrants.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->component('Entreprise/Encadrants/Index')
                    ->has('encadrants', 1)
                    ->where(
                        'encadrants.0.id',
                        $encadrant->id
                    )
            );
    }

    /** @test */
    public function test_entreprise_only_sees_its_own_supervisors(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $encadrant = $this->createEncadrant($entreprise);
        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.encadrants.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->component('Entreprise/Encadrants/Index')
                    ->has('encadrants', 1)
                    ->where(
                        'encadrants.0.id',
                        $encadrant->id
                    )
            );

        $this->assertNotEquals(
            $encadrant->id,
            $otherEncadrant->id
        );
    }

    /** @test */
    public function test_entreprise_can_view_create_supervisor_page(): void
    {
        $entreprise = $this->createEntreprise();
        $this->createVille();

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.encadrants.create'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->component('Entreprise/Encadrants/Create')
                    ->has('villes')
                    ->has('villes', 1)
            );
    }

    /** @test */
    public function test_entreprise_can_create_a_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.encadrants.store'), [
                'nom_complet' => 'Ahmed Supervisor',
                'email' => 'ahmed@example.com',
                'password' => 'Password123!',
                'telephone' => '0612345678',
                'poste' => 'Développeur Full Stack',
                'specialite' => 'Laravel',
                'departement' => 'IT',
                'ville_id' => $ville->id,
            ]);

        $response->assertRedirect(
            route(
                'entreprise.encadrants.index',
                absolute: false
            )
        );

        $response->assertSessionHas(
            'message',
            'Supervisor successfully created.'
        );

        $user = User::where(
            'email',
            'ahmed@example.com'
        )->first();

        $this->assertNotNull($user);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nom_complet' => 'Ahmed Supervisor',
            'role' => 'Encadrant',
            'etat' => 'active',
            'ville_id' => $ville->id,
        ]);

        $this->assertTrue(
            Hash::check(
                'Password123!',
                $user->password
            )
        );

        $this->assertDatabaseHas('encadrants', [
            'user_id' => $user->id,
            'poste' => 'Développeur Full Stack',
            'specialite' => 'Laravel',
            'departement' => 'IT',
            'entreprise_id' => $entreprise->id,
        ]);
    }

    /** @test */
    public function test_entreprise_cannot_create_supervisor_with_existing_email(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.encadrants.store'), [
                'nom_complet' => 'Another Supervisor',
                'email' => 'existing@example.com',
                'password' => 'Password123!',
                'telephone' => '0612345678',
                'poste' => 'Développeur',
                'specialite' => 'Laravel',
                'departement' => 'IT',
                'ville_id' => $ville->id,
            ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_entreprise_cannot_create_supervisor_with_invalid_city(): void
    {
        $entreprise = $this->createEntreprise();

        $response = $this->actingAs($entreprise)
            ->post(route('entreprise.encadrants.store'), [
                'nom_complet' => 'Invalid City',
                'email' => 'invalidcity@example.com',
                'password' => 'Password123!',
                'telephone' => '0612345678',
                'poste' => 'Développeur',
                'specialite' => 'Laravel',
                'departement' => 'IT',
                'ville_id' => 999999,
            ]);

        $response->assertSessionHasErrors('ville_id');

        $this->assertDatabaseMissing('users', [
            'email' => 'invalidcity@example.com',
        ]);
    }

    /** @test */
    public function test_entreprise_can_update_its_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $ville1 = $this->createVille();
        $ville2 = Ville::create([
            'nom' => 'Rabat',
        ]);

        $encadrant = $this->createEncadrant(
            $entreprise,
            $ville1
        );

        $response = $this->actingAs($entreprise)
            ->put(
                route(
                    'entreprise.encadrants.update',
                    $encadrant->id
                ),
                [
                    'nom_complet' => 'Updated Supervisor',
                    'email' => 'updated@example.com',
                    'telephone' => '0699999999',
                    'poste' => 'Senior Developer',
                    'specialite' => 'Vue.js',
                    'departement' => 'Engineering',
                    'ville_id' => $ville2->id,
                ]
            );

        $response->assertSessionHas(
            'message',
            'Supervisor information updated.'
        );

        $this->assertDatabaseHas('users', [
            'id' => $encadrant->id,
            'nom_complet' => 'Updated Supervisor',
            'email' => 'updated@example.com',
            'telephone' => '0699999999',
            'ville_id' => $ville2->id,
        ]);

        $this->assertDatabaseHas('encadrants', [
            'user_id' => $encadrant->id,
            'poste' => 'Senior Developer',
            'specialite' => 'Vue.js',
            'departement' => 'Engineering',
        ]);
    }

    /** @test */
    public function test_entreprise_can_keep_same_email_when_updating_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        $encadrant = $this->createEncadrant(
            $entreprise,
            $ville
        );

        $response = $this->actingAs($entreprise)
            ->put(
                route(
                    'entreprise.encadrants.update',
                    $encadrant->id
                ),
                [
                    'nom_complet' => 'Updated Name',
                    'email' => $encadrant->email,
                    'telephone' => '0611111111',
                    'poste' => 'Updated Poste',
                    'specialite' => 'Updated Specialite',
                    'departement' => 'Updated Department',
                    'ville_id' => $ville->id,
                ]
            );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $encadrant->id,
            'email' => $encadrant->email,
            'nom_complet' => 'Updated Name',
        ]);
    }

    /** @test */
    public function test_entreprise_cannot_update_another_company_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $ville = $this->createVille();

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise,
            $ville
        );

        $response = $this->actingAs($entreprise)
            ->put(
                route(
                    'entreprise.encadrants.update',
                    $otherEncadrant->id
                ),
                [
                    'nom_complet' => 'Unauthorized Update',
                    'email' => 'unauthorized@example.com',
                    'telephone' => '0600000000',
                    'poste' => 'Unauthorized',
                    'specialite' => 'Test',
                    'departement' => 'Test',
                    'ville_id' => $ville->id,
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('users', [
            'id' => $otherEncadrant->id,
            'nom_complet' => $otherEncadrant->nom_complet,
        ]);
    }

    /** @test */
    public function test_entreprise_can_reset_supervisor_password(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        $encadrant = $this->createEncadrant(
            $entreprise,
            $ville
        );

        $oldPassword = $encadrant->password;

        $response = $this->actingAs($entreprise)
            ->put(
                route(
                    'entreprise.encadrants.resetPassword',
                    $encadrant->id
                ),
                [
                    'password' => 'NewPassword123!',
                    'password_confirmation' => 'NewPassword123!',
                ]
            );

        $response->assertSessionHas(
            'message',
            'Supervisor password updated.'
        );

        $encadrant->refresh();

        $this->assertNotEquals(
            $oldPassword,
            $encadrant->password
        );

        $this->assertTrue(
            Hash::check(
                'NewPassword123!',
                $encadrant->password
            )
        );
    }

    /** @test */
    public function test_entreprise_cannot_reset_password_of_another_company_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $ville = $this->createVille();

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise,
            $ville
        );

        $oldPassword = $otherEncadrant->password;

        $response = $this->actingAs($entreprise)
            ->put(
                route(
                    'entreprise.encadrants.resetPassword',
                    $otherEncadrant->id
                ),
                [
                    'password' => 'NewPassword123!',
                    'password_confirmation' => 'NewPassword123!',
                ]
            );

        $response->assertNotFound();

        $otherEncadrant->refresh();

        $this->assertTrue(
            Hash::check(
                'password',
                $otherEncadrant->password
            )
        );

        $this->assertEquals(
            $oldPassword,
            $otherEncadrant->password
        );
    }

    /** @test */
    public function test_entreprise_can_delete_its_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        $encadrant = $this->createEncadrant(
            $entreprise,
            $ville
        );

        $response = $this->actingAs($entreprise)
            ->delete(
                route(
                    'entreprise.encadrants.destroy',
                    $encadrant->id
                )
            );

        $response->assertSessionHas(
            'message',
            'Supervisor successfully removed.'
        );

        $this->assertSoftDeleted('users', [
            'id' => $encadrant->id,
        ]);

        $this->assertSoftDeleted('encadrants', [
            'user_id' => $encadrant->id,
        ]);
    }

    /** @test */
    public function test_entreprise_cannot_delete_another_company_supervisor(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $ville = $this->createVille();

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise,
            $ville
        );

        $response = $this->actingAs($entreprise)
            ->delete(
                route(
                    'entreprise.encadrants.destroy',
                    $otherEncadrant->id
                )
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('users', [
            'id' => $otherEncadrant->id,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseHas('encadrants', [
            'user_id' => $otherEncadrant->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function test_entreprise_cannot_reset_password_with_invalid_confirmation(): void
    {
        $entreprise = $this->createEntreprise();
        $ville = $this->createVille();

        $encadrant = $this->createEncadrant(
            $entreprise,
            $ville
        );

        $response = $this->actingAs($entreprise)
            ->put(
                route(
                    'entreprise.encadrants.resetPassword',
                    $encadrant->id
                ),
                [
                    'password' => 'NewPassword123!',
                    'password_confirmation' => 'DifferentPassword123!',
                ]
            );

        $response->assertSessionHasErrors('password');
    }
}
