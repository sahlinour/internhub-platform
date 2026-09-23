<?php

namespace Tests\Feature\Encadrant;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private function createEncadrant(): User
    {
        return User::factory()->create([
            'role' => 'Encadrant',
        ]);
    }

    private function createNotification(
        User $user,
        string $titre = 'Nouvelle notification',
        bool $lu = false
    ): Notification {
        return Notification::create([
            'titre' => $titre,
            'message' => 'Message de notification de test.',
            'lu' => $lu,
            'date_envoi' => now(),
            'id_Utilisateur' => $user->id,
        ]);
    }

    public function test_encadrant_can_view_notifications(): void
    {
        $encadrant = $this->createEncadrant();

        $this->createNotification($encadrant);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->component('Encadrant/Notifications/Index')
                ->has('notifications', 1)
                ->where('unreadCount', 1)
        );
    }

    public function test_index_returns_only_own_notifications(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $notification1 = $this->createNotification(
            $encadrant1,
            'Notification encadrant 1'
        );

        $this->createNotification(
            $encadrant2,
            'Notification encadrant 2'
        );

        $response = $this->actingAs($encadrant1)
            ->get(route('encadrant.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->has('notifications', 1)
                ->where(
                    'notifications.0.id',
                    $notification1->id
                )
                ->where(
                    'notifications.0.titre',
                    'Notification encadrant 1'
                )
        );
    }

    public function test_unread_count_counts_only_unread_notifications(): void
    {
        $encadrant = $this->createEncadrant();

        $this->createNotification(
            $encadrant,
            'Non lue 1',
            false
        );

        $this->createNotification(
            $encadrant,
            'Lue',
            true
        );

        $this->createNotification(
            $encadrant,
            'Non lue 2',
            false
        );

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where('unreadCount', 2)
                ->has('notifications', 3)
        );
    }

    public function test_notifications_are_ordered_by_date_descending(): void
    {
        $encadrant = $this->createEncadrant();

        $older = Notification::create([
            'titre' => 'Ancienne notification',
            'message' => 'Ancienne notification.',
            'lu' => false,
            'date_envoi' => now()->subDay(),
            'id_Utilisateur' => $encadrant->id,
        ]);

        $newer = Notification::create([
            'titre' => 'Nouvelle notification',
            'message' => 'Nouvelle notification.',
            'lu' => false,
            'date_envoi' => now(),
            'id_Utilisateur' => $encadrant->id,
        ]);

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->where(
                'notifications.0.id',
                $newer->id
            )
                ->where(
                    'notifications.1.id',
                    $older->id
                )
        );
    }

    public function test_encadrant_can_mark_own_notification_as_read(): void
    {
        $encadrant = $this->createEncadrant();

        $notification = $this->createNotification(
            $encadrant,
            'Notification à lire',
            false
        );

        $response = $this->actingAs($encadrant)
            ->patch(
                route(
                    'encadrant.notifications.read',
                    $notification->id
                )
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'id_Utilisateur' => $encadrant->id,
            'lu' => true,
        ]);
    }

    public function test_encadrant_cannot_mark_another_users_notification_as_read(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $notification = $this->createNotification(
            $encadrant2,
            'Notification privée',
            false
        );

        $response = $this->actingAs($encadrant1)
            ->patch(
                route(
                    'encadrant.notifications.read',
                    $notification->id
                )
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'lu' => false,
        ]);
    }

    public function test_encadrant_can_mark_all_own_notifications_as_read(): void
    {
        $encadrant = $this->createEncadrant();

        $notification1 = $this->createNotification(
            $encadrant,
            'Notification 1',
            false
        );

        $notification2 = $this->createNotification(
            $encadrant,
            'Notification 2',
            false
        );

        $notification3 = $this->createNotification(
            $encadrant,
            'Notification déjà lue',
            true
        );

        $response = $this->actingAs($encadrant)
            ->patch(
                route('encadrant.notifications.readAll')
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification1->id,
            'lu' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $notification2->id,
            'lu' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $notification3->id,
            'lu' => true,
        ]);
    }

    public function test_mark_all_as_read_does_not_modify_another_users_notifications(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $ownNotification = $this->createNotification(
            $encadrant1,
            'Ma notification',
            false
        );

        $otherNotification = $this->createNotification(
            $encadrant2,
            'Notification autre utilisateur',
            false
        );

        $response = $this->actingAs($encadrant1)
            ->patch(
                route('encadrant.notifications.readAll')
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id' => $ownNotification->id,
            'lu' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $otherNotification->id,
            'lu' => false,
        ]);
    }

    public function test_encadrant_can_delete_own_notification(): void
    {
        $encadrant = $this->createEncadrant();

        $notification = $this->createNotification(
            $encadrant,
            'Notification à supprimer'
        );

        $response = $this->actingAs($encadrant)
            ->delete(
                route(
                    'encadrant.notifications.destroy',
                    $notification->id
                )
            );

        $response->assertRedirect();

        $this->assertSoftDeleted('notifications', [
            'id' => $notification->id,
        ]);
    }

    public function test_encadrant_cannot_delete_another_users_notification(): void
    {
        $encadrant1 = $this->createEncadrant();
        $encadrant2 = $this->createEncadrant();

        $notification = $this->createNotification(
            $encadrant2,
            'Notification privée'
        );

        $response = $this->actingAs($encadrant1)
            ->delete(
                route(
                    'encadrant.notifications.destroy',
                    $notification->id
                )
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'deleted_at' => null,
        ]);
    }

    public function test_deleted_notification_is_not_returned_in_index(): void
    {
        $encadrant = $this->createEncadrant();

        $notification = $this->createNotification(
            $encadrant,
            'Notification supprimée'
        );

        $notification->delete();

        $response = $this->actingAs($encadrant)
            ->get(route('encadrant.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn ($page) =>
            $page->has('notifications', 0)
                ->where('unreadCount', 0)
        );
    }

    public function test_guest_cannot_access_notifications(): void
    {
        $response = $this->get(
            route('encadrant.notifications.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_non_encadrant_cannot_access_notifications(): void
    {
        $user = User::factory()->create([
            'role' => 'Stagiaire',
        ]);

        $response = $this->actingAs($user)
            ->get(route('encadrant.notifications.index'));

        $response->assertForbidden();
    }
}