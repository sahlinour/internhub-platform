<?php

namespace Tests\Feature\Encadrant;

use App\Models\Candidature;
use App\Models\Document;
use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Offredestage;
use App\Models\Stage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    private function createEncadrant(): User
    {
        $entreprise = User::factory()->create([
            'role' => 'Entreprise',
        ]);

        Entreprise::create([
            'user_id' => $entreprise->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tangier',
            'site_web' => 'https://example.com',
            'description' => 'Entreprise de test',
        ]);

        $encadrant = User::factory()->create([
            'role' => 'Encadrant',
        ]);

        Encadrant::create([
            'user_id' => $encadrant->id,
            'entreprise_id' => $entreprise->id,
            'poste' => 'Encadrant',
            'specialite' => 'Développement',
            'departement' => 'IT',
        ]);

        return $encadrant;
    }

    private function createStagiaire(): User
    {
        $stagiaire = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        Stagiaire::create([
            'user_id' => $stagiaire->id,
        ]);

        return $stagiaire;
    }

    private function createStage(User $encadrant): Stage
    {
        $stagiaire = $this->createStagiaire();

        $entreprise = $encadrant->encadrant->entreprise;

        $offre = Offredestage::create([
            'titre' => 'Stage Développement Web',
            'description' => 'Stage de développement',
            'duree' => '3 mois',
            'date_limite' => now()->addMonth()->toDateString(),
            'statut' => 'ouverte',
            'idUtilisateur_Entreprise' => $entreprise->user_id,
        ]);

        $candidature = Candidature::create([
            'statut' => 'acceptee',
            'date_postulation' => now()->toDateString(),
            'lettre_de_motivation' => 'Je souhaite rejoindre votre entreprise.',
            'piece_jointe' => null,
            'cv_url' => null,
            'idUtilisateur_Stagiaire' => $stagiaire->id,
            'id_Offre_De_Stage' => $offre->id,
        ]);

        return Stage::create([
            'sujet' => 'Développement de la plateforme',
            'date_debut' => now()->toDateString(),
            'date_fin' => now()->addMonths(3)->toDateString(),
            'statut' => 'en_cours',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Candidature' => $candidature->id,
        ]);
    }

    private function createDocument(
        Stage $stage,
        User $encadrant,
        string $nom = 'Rapport de stage',
        string $statut = 'en_attente'
    ): Document {
        return Document::create([
            'nom' => $nom,
            'version' => 'v1.0',
            'statut' => $statut,
            'fichier_url' => 'documents/test-document.pdf',
            'idUtilisateur_Encadrant' => $encadrant->id,
            'id_Stage' => $stage->id,
        ]);
    }

    public function test_encadrant_can_view_own_documents(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $document = $this->createDocument($stage, $encadrant);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.documents.index'));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Documents/Index')
                ->has('documents.data', 1)
                ->where('documents.data.0.id', $document->id)
                ->where('documents.data.0.nom', 'Rapport de stage')
        );
    }

    public function test_encadrant_cannot_view_another_encadrants_documents(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage = $this->createStage($encadrant2);
        $document = $this->createDocument(
            $stage,
            $encadrant2,
            'Document privé'
        );

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.documents.index'));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Documents/Index')
                ->has('documents.data', 0)
        );

        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
        ]);
    }

    public function test_documents_are_ordered_by_creation_date_descending(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $older = $this->createDocument(
            $stage,
            $encadrant,
            'Ancien document'
        );

        $newer = $this->createDocument(
            $stage,
            $encadrant,
            'Nouveau document'
        );

        $older->created_at = now()->subDay();
        $older->save();

        $newer->created_at = now();
        $newer->save();

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.documents.index'));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Documents/Index')
                ->where(
                    'documents.data.0.id',
                    $newer->id
                )
                ->where(
                    'documents.data.1.id',
                    $older->id
                )
        );
    }

    public function test_encadrant_can_view_task_reviews(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $document = $this->createDocument(
            $stage,
            $encadrant,
            'Rapport à vérifier'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index'));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/TaskReviews/Index')
                ->has('documents.data', 1)
                ->where('documents.data.0.id', $document->id)
                ->where('filters.search', '')
                ->where('filters.status', 'all')
        );
    }

    public function test_task_reviews_can_filter_by_status(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $pending = $this->createDocument(
            $stage,
            $encadrant,
            'Document en attente',
            'en_attente'
        );

        $validated = $this->createDocument(
            $stage,
            $encadrant,
            'Document valide',
            'valide'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index', [
                'status' => 'valide',
            ]));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/TaskReviews/Index')
                ->has('documents.data', 1)
                ->where('documents.data.0.id', $validated->id)
                ->where('filters.status', 'valide')
        );

        $this->assertNotEquals($pending->id, $validated->id);
    }

    public function test_task_reviews_default_to_all_statuses(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $this->createDocument(
            $stage,
            $encadrant,
            'Document en attente',
            'en_attente'
        );

        $this->createDocument(
            $stage,
            $encadrant,
            'Document valide',
            'valide'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index'));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->where('filters.status', 'all')
                ->has('documents.data', 2)
        );
    }

    public function test_invalid_review_status_defaults_to_all(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $this->createDocument(
            $stage,
            $encadrant,
            'Document test',
            'en_attente'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index', [
                'status' => 'invalid',
            ]));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->where('filters.status', 'all')
        );
    }

    public function test_task_reviews_can_search_by_document_name(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $matching = $this->createDocument(
            $stage,
            $encadrant,
            'Rapport Final'
        );

        $this->createDocument(
            $stage,
            $encadrant,
            'Document différent'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index', [
                'search' => 'Rapport',
            ]));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->has('documents.data', 1)
                ->where('documents.data.0.id', $matching->id)
                ->where('filters.search', 'Rapport')
        );
    }

    public function test_task_reviews_can_search_by_intern_name(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $stage->candidature->stagiaire->user->update([
            'nom_complet' => 'Nour Sahli',
        ]);

        $matching = $this->createDocument(
            $stage,
            $encadrant,
            'Document stagiaire'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index', [
                'search' => 'Nour',
            ]));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->has('documents.data', 1)
                ->where('documents.data.0.id', $matching->id)
        );
    }

    public function test_task_reviews_can_search_by_internship_subject(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $stage->update([
            'sujet' => 'Application Mobile Flutter',
        ]);

        $matching = $this->createDocument(
            $stage,
            $encadrant,
            'Document projet'
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.task-reviews.index', [
                'search' => 'Flutter',
            ]));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->has('documents.data', 1)
                ->where('documents.data.0.id', $matching->id)
        );
    }

    public function test_encadrant_can_view_one_document(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $document = $this->createDocument(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.documents.show', $document->id));

        $response->assertOk();
        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Documents/Show')
                ->where('document.id', $document->id)
                ->where('document.nom', 'Rapport de stage')
        );
    }

    public function test_encadrant_cannot_view_another_encadrants_document(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage = $this->createStage($encadrant2);
        $document = $this->createDocument(
            $stage,
            $encadrant2
        );

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.documents.show', $document->id));

        $response->assertNotFound();
    }

    public function test_encadrant_can_download_own_document(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $path = 'documents/test-document.pdf';
        $fullPath = storage_path('app/public/' . $path);

        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        file_put_contents(
            $fullPath,
            'fake pdf content'
        );

        $document = $this->createDocument(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->get(
                route(
                    'encadrant.documents.download',
                    $document->id
                )
            );

        $response->assertOk();
        $response->assertDownload('Rapport de stage');

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function test_encadrant_cannot_download_another_encadrants_document(): void
    {
        Storage::fake('public');

        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage = $this->createStage($encadrant2);
        $path = 'documents/private-document.pdf';

        Storage::disk('public')->put(
            $path,
            'private document'
        );

        $document = $this->createDocument(
            $stage,
            $encadrant2,
            'Document privé'
        );

        $document->update([
            'fichier_url' => $path,
        ]);

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.documents.download', $document->id));

        $response->assertNotFound();
    }

    public function test_encadrant_can_update_document_status(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $document = $this->createDocument(
            $stage,
            $encadrant,
            'Rapport à valider',
            'en_attente'
        );

        $response = $this->actingAs($encadrant)
            ->patch(
                route('encadrant.documents.updateStatus', $document->id),
                [
                    'statut' => 'valide',
                ]
            );

        $response->assertRedirect();
        $response->assertSessionHas(
            'message',
            'Document status updated successfully.'
        );

        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
            'statut' => 'valide',
        ]);
    }

    public function test_encadrant_cannot_update_another_encadrants_document_status(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage = $this->createStage($encadrant2);

        $document = $this->createDocument(
            $stage,
            $encadrant2,
            'Document privé',
            'en_attente'
        );

        $response = $this->actingAs($encadrant1)
            ->patch(
                route('encadrant.documents.updateStatus', $document->id),
                [
                    'statut' => 'valide',
                ]
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
            'statut' => 'en_attente',
        ]);
    }

    public function test_document_status_update_validates_status(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $document = $this->createDocument(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->patch(
                route('encadrant.documents.updateStatus', $document->id
                ),
                [
                    'statut' => 'invalid_status',
                ]
            );

        $response->assertSessionHasErrors('statut');
    }

    public function test_encadrant_can_delete_own_document(): void
    {
        $encadrant = $this->createEncadrant();
        $stage = $this->createStage($encadrant);

        $document = $this->createDocument(
            $stage,
            $encadrant
        );

        $response = $this->actingAs($encadrant)
            ->delete(
                route('encadrant.documents.destroy', $document->id)
            );

        $response->assertRedirect();
        $response->assertSessionHas(
            'message',
            'Document deleted successfully.'
        );

        $this->assertSoftDeleted('documents', [
            'id' => $document->id,
        ]);
    }

    public function test_encadrant_cannot_delete_another_encadrants_document(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $stage = $this->createStage($encadrant2);

        $document = $this->createDocument(
            $stage,
            $encadrant2
        );

        $response = $this->actingAs($encadrant1)
            ->delete(
                route('encadrant.documents.destroy', $document->id)
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
            'deleted_at' => null,
        ]);
    }

    public function test_guest_cannot_access_encadrant_documents(): void
    {
        $response = $this->get(
            route('encadrant.documents.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_non_encadrant_cannot_access_encadrant_documents(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $response = $this->actingAs($user)
            ->get(route('encadrant.documents.index'));

        $response->assertForbidden();
    }
}