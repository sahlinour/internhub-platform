<?php

namespace Tests\Feature\Stagiaire;

use App\Models\Candidature;
use App\Models\Document;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
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

    private function createStageForStagiaire(Stagiaire $stagiaire): Stage
    {
        // Entreprise
        $entrepriseUser = User::factory()->create([
            'role' => 'Entreprise',
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $entrepriseUser->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tanger',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de test',
        ]);

        // Encadrant
        $encadrantUser = User::factory()->create([
            'role' => 'Encadrant',
        ]);

        $encadrant = Encadrant::create([
            'user_id' => $encadrantUser->id,
            'poste' => 'Développeur Full Stack',
            'specialite' => 'Laravel',
            'departement' => 'IT',
            'entreprise_id' => $entreprise->user_id,
        ]);

        // Offre
        $offer = \App\Models\Offredestage::create([
            'titre' => 'Stage Laravel',
            'description' => 'Stage de développement Laravel',
            'duree' => '3 mois',
            'date_limite' => '2026-12-31',
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entreprise->user_id,
        ]);

        // Candidature
        $candidature = Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite effectuer ce stage.',
            'idUtilisateur_Stagiaire' => $stagiaire->user_id,
            'id_Offre_De_Stage' => $offer->id,
        ]);

        // Stage
        return Stage::create([
            'sujet' => 'Développement d’une application web',
            'date_debut' => '2026-09-01',
            'date_fin' => '2026-12-01',
            'statut' => 'En cours',
            'idUtilisateur_Encadrant' => $encadrant->user_id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    public function test_stagiaire_can_view_documents(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        Document::create([
            'nom' => 'Rapport de stage',
            'version' => 'v1.0',
            'statut' => 'en_attente',
            'fichier_url' => 'documents/rapport.pdf',
            'idUtilisateur_Encadrant' => $stage->idUtilisateur_Encadrant,
            'id_Stage' => $stage->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('stagiaire.documents.index'));

        $response->assertStatus(200);
    }

    public function test_stagiaire_only_sees_documents_from_own_stage(): void
    {
        [$user1, $stagiaire1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $stage1 = $this->createStageForStagiaire($stagiaire1);
        $stage2 = $this->createStageForStagiaire($stagiaire2);

        $document1 = Document::create([
            'nom' => 'Document stagiaire 1',
            'version' => 'v1.0',
            'statut' => 'en_attente',
            'fichier_url' => 'documents/stagiaire1.pdf',
            'idUtilisateur_Encadrant' => $stage1->idUtilisateur_Encadrant,
            'id_Stage' => $stage1->id,
        ]);

        Document::create([
            'nom' => 'Document stagiaire 2',
            'version' => 'v1.0',
            'statut' => 'en_attente',
            'fichier_url' => 'documents/stagiaire2.pdf',
            'idUtilisateur_Encadrant' => $stage2->idUtilisateur_Encadrant,
            'id_Stage' => $stage2->id,
        ]);

        $response = $this->actingAs($user1)
            ->get(route('stagiaire.documents.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Stagiaire/Documents/Index')
                ->has('documents.data', 1)
                ->where('documents.data.0.id', $document1->id)
        );
    }

    public function test_stagiaire_can_upload_document_to_own_stage(): void
    {
        Storage::fake('public');

        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $file = UploadedFile::fake()->create(
            'rapport.pdf',
            500,
            'application/pdf'
        );

        $response = $this->actingAs($user)
            ->post(route('stagiaire.documents.store'), [
                'id_Stage' => $stage->id,
                'nom' => 'Rapport de stage',
                'fichier' => $file,
            ]);

        $response->assertSessionHas(
            'message',
            'Document uploaded successfully.'
        );

        $document = Document::first();

        $this->assertNotNull($document);

        $this->assertSame('Rapport de stage', $document->nom);
        $this->assertSame('v1.0', $document->version);
        $this->assertSame('en_attente', $document->statut);
        $this->assertSame(
            $stage->idUtilisateur_Encadrant,
            $document->idUtilisateur_Encadrant
        );
        $this->assertSame($stage->id, $document->id_Stage);

        Storage::disk('public')->assertExists($document->fichier_url);
    }

    public function test_stagiaire_can_upload_document_with_custom_version(): void
    {
        Storage::fake('public');

        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $file = UploadedFile::fake()->create(
            'rapport-v2.pdf',
            500,
            'application/pdf'
        );

        $this->actingAs($user)
            ->post(route('stagiaire.documents.store'), [
                'id_Stage' => $stage->id,
                'nom' => 'Rapport corrigé',
                'version' => 'v2.0',
                'fichier' => $file,
            ]);

        $this->assertDatabaseHas('documents', [
            'nom' => 'Rapport corrigé',
            'version' => 'v2.0',
            'statut' => 'en_attente',
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_stagiaire_cannot_upload_document_to_another_stagiaire_stage(): void
    {
        Storage::fake('public');

        [$user1] = $this->createStagiaire();
        [, $stagiaire2] = $this->createStagiaire();

        $stage2 = $this->createStageForStagiaire($stagiaire2);

        $file = UploadedFile::fake()->create(
            'document.pdf',
            500,
            'application/pdf'
        );

        $response = $this->actingAs($user1)
            ->post(route('stagiaire.documents.store'), [
                'id_Stage' => $stage2->id,
                'nom' => 'Document interdit',
                'fichier' => $file,
            ]);

        $response->assertNotFound();

        $this->assertDatabaseCount('documents', 0);
    }

    public function test_document_requires_valid_file(): void
    {
        [$user, $stagiaire] = $this->createStagiaire();

        $stage = $this->createStageForStagiaire($stagiaire);

        $response = $this->actingAs($user)
            ->post(route('stagiaire.documents.store'), [
                'id_Stage' => $stage->id,
                'nom' => 'Document invalide',
                'fichier' => UploadedFile::fake()->create(
                    'document.txt',
                    100,
                    'text/plain'
                ),
            ]);

        $response->assertSessionHasErrors('fichier');
    }

    public function test_document_requires_name_and_stage(): void
    {
        [$user] = $this->createStagiaire();

        $response = $this->actingAs($user)
            ->post(route('stagiaire.documents.store'), [
                'fichier' => UploadedFile::fake()->create(
                    'document.pdf',
                    100,
                    'application/pdf'
                ),
            ]);

        $response->assertSessionHasErrors([
            'id_Stage',
            'nom',
        ]);
    }
}