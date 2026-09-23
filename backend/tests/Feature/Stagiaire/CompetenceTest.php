<?php

namespace Tests\Feature\Stagiaire;

use App\Models\Competence;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetenceTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_stagiaire_can_view_competences(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.competences.index'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_can_add_a_competence(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('stagiaire.competences.store'), [
                'nom_competence' => 'Laravel',
                'niveau' => 'Avancé',
                'experience' => '2 ans',
            ]);

        $response->assertSessionHasNoErrors();

        $competence = Competence::where(
            'nom_competence',
            'Laravel'
        )->first();

        $this->assertNotNull($competence);

        $this->assertDatabaseHas('possedes', [
            'id_Competence' => $competence->id,
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'niveau' => 'Avancé',
            'experience' => '2 ans',
        ]);
    }

    public function test_stagiaire_reuses_existing_competence(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $competence = Competence::create([
            'nom_competence' => 'Laravel',
        ]);

        $this->actingAs($user)
            ->post(route('stagiaire.competences.store'), [
                'nom_competence' => 'Laravel',
                'niveau' => 'Intermédiaire',
                'experience' => '1 an',
            ]);

        $this->assertDatabaseCount('competences', 1);

        $this->assertDatabaseHas('possedes', [
            'id_Competence' => $competence->id,
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
        ]);
    }

    public function test_stagiaire_can_update_competence(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $competence = Competence::create([
            'nom_competence' => 'Laravel',
        ]);

        $stagiaire->competences()->attach($competence->id, [
            'niveau' => 'Débutant',
            'experience' => '6 mois',
            'date_ajout' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)
            ->put(
                route('stagiaire.competences.update', $competence->id),
                [
                    'niveau' => 'Avancé',
                    'experience' => '2 ans',
                ]
            );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('possedes', [
            'id_Competence' => $competence->id,
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'niveau' => 'Avancé',
            'experience' => '2 ans',
        ]);
    }

    public function test_stagiaire_can_remove_competence(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $competence = Competence::create([
            'nom_competence' => 'Laravel',
        ]);

        $stagiaire->competences()->attach($competence->id, [
            'niveau' => 'Avancé',
            'experience' => '2 ans',
            'date_ajout' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)
            ->delete(
                route('stagiaire.competences.destroy', $competence->id)
            );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('possedes', [
            'id_Competence' => $competence->id,
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
        ]);
    }

    public function test_competence_creation_requires_name_and_level(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('stagiaire.competences.store'), []);

        $response->assertSessionHasErrors([
            'nom_competence',
            'niveau',
        ]);
    }
}