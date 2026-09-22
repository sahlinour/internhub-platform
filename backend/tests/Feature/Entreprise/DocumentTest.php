<?php

namespace Tests\Feature\Entreprise;

use App\Models\Candidature;
use App\Models\Document;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
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
        Offredestage $offre
    ): Candidature {
        return Candidature::create([
            'statut' => 'acceptee',
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
        User $encadrant
    ): Stage {
        return Stage::create([
            'sujet' => 'Développement de la plateforme InternHub',
            'date_debut' => now()->addDay()->toDateString(),
            'date_fin' => now()->addMonths(3)->toDateString(),
            'statut' => 'en_cours',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    private function createDocument(
        Stage $stage,
        User $encadrant,
        string $nom = 'Rapport de stage'
    ): Document {
        return Document::create([
            'nom' => $nom,
            'version' => 'v1.0',
            'statut' => 'en_attente',
            'fichier_url' => 'documents/test.pdf',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_entreprise_can_view_documents_of_its_internships(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);
        $candidature = $this->createCandidature(
            $stagiaire,
            $offre
        );

        $stage = $this->createStage(
            $candidature,
            $encadrant
        );

        $document = $this->createDocument(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.documents.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page
                    ->has('documents.data', 1)
                    ->where(
                        'documents.data.0.id',
                        $document->id
                    )
            );
    }

    public function test_entreprise_gets_empty_documents_list_when_no_documents_exist(): void
    {
        $entreprise = $this->createEntreprise();

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.documents.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->has('documents.data', 0)
            );
    }

    public function test_entreprise_only_sees_documents_from_its_own_company(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant1 = $this->createEncadrant($entreprise);
        $encadrant2 = $this->createEncadrant($otherEntreprise);

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($otherEntreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1),
            $encadrant1
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2),
            $encadrant2
        );

        $document1 = $this->createDocument(
            $stage1,
            $encadrant1,
            'Company 1 Document'
        );

        $document2 = $this->createDocument(
            $stage2,
            $encadrant2,
            'Company 2 Document'
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.documents.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->has('documents.data', 1)
                    ->where(
                        'documents.data.0.id',
                        $document1->id
                    )
            );

        $this->assertNotEquals(
            $document1->id,
            $document2->id
        );
    }

    public function test_entreprise_can_filter_documents_by_stage(): void
    {
        $entreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant = $this->createEncadrant($entreprise);

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($entreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1),
            $encadrant
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2),
            $encadrant
        );

        $document1 = $this->createDocument(
            $stage1,
            $encadrant,
            'Document Stage 1'
        );

        $this->createDocument(
            $stage2,
            $encadrant,
            'Document Stage 2'
        );

        $response = $this->actingAs($entreprise)
            ->get(
                route(
                    'entreprise.documents.index',
                    ['stage_id' => $stage1->id]
                )
            );

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->has('documents.data', 1)
                    ->where(
                        'documents.data.0.id',
                        $document1->id
                    )
                    ->where(
                        'filters.stage_id',
                        (string) $stage1->id
                    )
            );
    }

    public function test_stage_filter_does_not_return_documents_from_other_stages(): void
    {
        $entreprise = $this->createEntreprise();

        $stagiaire1 = $this->createStagiaire();
        $stagiaire2 = $this->createStagiaire();

        $encadrant = $this->createEncadrant($entreprise);

        $offre1 = $this->createOffer($entreprise);
        $offre2 = $this->createOffer($entreprise);

        $stage1 = $this->createStage(
            $this->createCandidature($stagiaire1, $offre1),
            $encadrant
        );

        $stage2 = $this->createStage(
            $this->createCandidature($stagiaire2, $offre2),
            $encadrant
        );

        $document1 = $this->createDocument(
            $stage1,
            $encadrant,
            'Stage 1 Document'
        );

        $document2 = $this->createDocument(
            $stage2,
            $encadrant,
            'Stage 2 Document'
        );

        $response = $this->actingAs($entreprise)
            ->get(
                route(
                    'entreprise.documents.index',
                    ['stage_id' => $stage2->id]
                )
            );

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->has('documents.data', 1)
                    ->where(
                        'documents.data.0.id',
                        $document2->id
                    )
            );

        $this->assertNotEquals(
            $document1->id,
            $document2->id
        );
    }

    public function test_entreprise_cannot_see_documents_from_another_company_even_with_stage_filter(): void
    {
        $entreprise = $this->createEntreprise();
        $otherEntreprise = $this->createEntreprise();

        $stagiaire = $this->createStagiaire();

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise
        );

        $otherOffer = $this->createOffer(
            $otherEntreprise
        );

        $otherCandidature = $this->createCandidature(
            $stagiaire,
            $otherOffer
        );

        $otherStage = $this->createStage(
            $otherCandidature,
            $otherEncadrant
        );

        $otherDocument = $this->createDocument(
            $otherStage,
            $otherEncadrant
        );

        $response = $this->actingAs($entreprise)
            ->get(
                route(
                    'entreprise.documents.index',
                    ['stage_id' => $otherStage->id]
                )
            );

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->has('documents.data', 0)
            );

        $this->assertDatabaseHas('documents', [
            'id' => $otherDocument->id,
            'id_Stage' => $otherStage->id,
        ]);
    }

    public function test_documents_include_stage_student_and_supervisor_information(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);

        $candidature = $this->createCandidature(
            $stagiaire,
            $offre
        );

        $stage = $this->createStage(
            $candidature,
            $encadrant
        );

        $document = $this->createDocument(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.documents.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->where(
                        'documents.data.0.id',
                        $document->id
                    )
                    ->where(
                        'documents.data.0.stage.id',
                        $stage->id
                    )
                    ->where(
                        'documents.data.0.stage.candidature.id',
                        $candidature->id
                    )
                    ->where(
                        'documents.data.0.stage.candidature.stagiaire.user.id',
                        $stagiaire->id
                    )
                    ->where(
                        'documents.data.0.encadrant.user.id',
                        $encadrant->id
                    )
            );
    }

    public function test_documents_are_returned_with_pagination_structure(): void
    {
        $entreprise = $this->createEntreprise();
        $stagiaire = $this->createStagiaire();
        $encadrant = $this->createEncadrant($entreprise);

        $offre = $this->createOffer($entreprise);

        $stage = $this->createStage(
            $this->createCandidature(
                $stagiaire,
                $offre
            ),
            $encadrant
        );

        $this->createDocument(
            $stage,
            $encadrant,
            'Test Document'
        );

        $response = $this->actingAs($entreprise)
            ->get(route('entreprise.documents.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page

                    ->has('documents.data')
                    ->has('documents.current_page')
                    ->has('documents.per_page')
                    ->has('documents.total')
                    ->where('documents.total', 1)
            );
    }
}
