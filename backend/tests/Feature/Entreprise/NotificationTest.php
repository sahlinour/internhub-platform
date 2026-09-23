<?php

namespace Tests\Feature\Entreprise;

use App\Models\Encadrant;
use App\Models\Entreprise;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private function createEntreprise(string $email): User
    {
        $user = User::factory()->create([
            'email' => $email,
            'role' => 'Entreprise',
        ]);

        Entreprise::create([
            'user_id' => $user->id,
            'secteur' => 'Informatique',
            'adresse' => 'Tangier',
            'site_web' => null,
            'description' => 'Test company',
        ]);

        return $user;
    }

    private function createEncadrant(
        User $entreprise,
        string $email
    ): User {
        $user = User::factory()->create([
            'email' => $email,
            'role' => 'Encadrant',
        ]);

        Encadrant::create([
            'user_id' => $user->id,
            'entreprise_id' => $entreprise->id,
            'poste' => 'Supervisor',
            'specialite' => 'Development',
            'departement' => 'IT',
        ]);

        return $user;
    }

    private function createNotification(
        User $recipient,
        bool $read = false,
        ?string $title = null
    ): Notification {
        return Notification::create([
            'titre' => $title ?? 'Test notification',
            'message' => 'Test notification message',
            'lu' => $read,
            'date_envoi' => now(),
            'id_Utilisateur' => $recipient->id,
        ]);
    }

    public function test_entreprise_can_view_only_its_own_notifications(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'role' => 'Entreprise',
        ]);

        $ownNotification = $this->createNotification(
            $entreprise,
            false,
            'My notification'
        );

        $otherNotification = $this->createNotification(
            $otherUser,
            false,
            'Other notification'
        );

        $response = $this
            ->actingAs($entreprise)
            ->get(route('entreprise.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Entreprise/Notifications/Index')
                ->has('notifications', 1)
                ->where(
                    'notifications.0.id',
                    $ownNotification->id
                )
                ->where(
                    'notifications.0.titre',
                    'My notification'
                )
                ->where('unreadCount', 1)
        );

        $this->assertDatabaseHas('notifications', [
            'id' => $ownNotification->id,
            'id_Utilisateur' => $entreprise->id,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $otherNotification->id,
            'id_Utilisateur' => $otherUser->id,
        ]);
    }

    public function test_entreprise_can_view_notifications_with_zero_unread_count(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $this->createNotification($entreprise, true, 'Read 1');
        $this->createNotification($entreprise, true, 'Read 2');

        $response = $this
            ->actingAs($entreprise)
            ->get(route('entreprise.notifications.index'));

        $response->assertOk();

        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Entreprise/Notifications/Index')
                ->has('notifications', 2)
                ->where('unreadCount', 0)
        );
    }

    public function test_entreprise_can_mark_its_notification_as_read(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $notification = $this->createNotification(
            $entreprise,
            false,
            'Unread notification'
        );

        $response = $this
            ->actingAs($entreprise)
            ->patch(route('entreprise.notifications.read',$notification->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'id_Utilisateur' => $entreprise->id,
            'lu' => true,
        ]);
    }

    public function test_entreprise_cannot_mark_another_users_notification_as_read(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'role' => 'Entreprise',
        ]);

        $notification = $this->createNotification(
            $otherUser,
            false,
            'Other notification'
        );

        $response = $this
            ->actingAs($entreprise)
            ->patch(route(
                'entreprise.notifications.read',
                $notification->id
            ));

        $response->assertNotFound();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'id_Utilisateur' => $otherUser->id,
            'lu' => false,
        ]);
    }

    public function test_entreprise_can_mark_all_its_notifications_as_read(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $first = $this->createNotification($entreprise, false, 'First');
        $second = $this->createNotification($entreprise, false, 'Second');
        $read = $this->createNotification($entreprise, true, 'Already read');

        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'role' => 'Entreprise',
        ]);

        $otherNotification = $this->createNotification(
            $otherUser,
            false,
            'Other'
        );

        $response = $this
            ->actingAs($entreprise)
            ->patch(route('entreprise.notifications.readAll'));

        $response->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id' => $first->id,
            'lu' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $second->id,
            'lu' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $read->id,
            'lu' => true,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $otherNotification->id,
            'id_Utilisateur' => $otherUser->id,
            'lu' => false,
        ]);
    }

    public function test_entreprise_can_send_notification_to_its_own_encadrant(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');
        $encadrant = $this->createEncadrant(
            $entreprise,
            'encadrant@example.com'
        );

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.sendToEncadrant'),
                [
                    'id_Utilisateur' => $encadrant->id,
                    'titre' => 'Important message',
                    'message' => 'Please review the internship documents.',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHas(
            'message',
            'Notification sent to the encadrant successfully.'
        );

        $this->assertDatabaseHas('notifications', [
            'id_Utilisateur' => $encadrant->id,
            'titre' => 'Important message',
            'message' => 'Please review the internship documents.',
            'lu' => false,
        ]);
    }

    public function test_entreprise_cannot_send_notification_to_another_enterprises_encadrant(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');
        $otherEntreprise = $this->createEntreprise('other-company@example.com');

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise,
            'other-encadrant@example.com'
        );

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.sendToEncadrant'),
                [
                    'id_Utilisateur' => $otherEncadrant->id,
                    'titre' => 'Unauthorized',
                    'message' => 'This should not be sent.',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHasErrors([
            'id_Utilisateur',
        ]);

        $this->assertDatabaseMissing('notifications', [
            'id_Utilisateur' => $otherEncadrant->id,
            'titre' => 'Unauthorized',
        ]);
    }

    public function test_send_notification_requires_valid_data(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.sendToEncadrant'),
                []
            );

        $response->assertSessionHasErrors([
            'id_Utilisateur',
            'titre',
            'message',
        ]);
    }

    public function test_entreprise_can_broadcast_notification_to_all_its_encadrants(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $encadrantOne = $this->createEncadrant(
            $entreprise,
            'encadrant1@example.com'
        );

        $encadrantTwo = $this->createEncadrant(
            $entreprise,
            'encadrant2@example.com'
        );

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.broadcastToEncadrants'),
                [
                    'titre' => 'Team announcement',
                    'message' => 'Meeting tomorrow at 10 AM.',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHas(
            'message',
            'Notification broadcast to all your encadrants.'
        );

        $this->assertDatabaseHas('notifications', [
            'id_Utilisateur' => $encadrantOne->id,
            'titre' => 'Team announcement',
            'message' => 'Meeting tomorrow at 10 AM.',
            'lu' => false,
        ]);

        $this->assertDatabaseHas('notifications', [
            'id_Utilisateur' => $encadrantTwo->id,
            'titre' => 'Team announcement',
            'message' => 'Meeting tomorrow at 10 AM.',
            'lu' => false,
        ]);

        $this->assertDatabaseCount('notifications', 2);
    }

    public function test_broadcast_does_not_send_to_other_enterprises_encadrants(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');
        $otherEntreprise = $this->createEntreprise('other-company@example.com');

        $ownEncadrant = $this->createEncadrant(
            $entreprise,
            'own-encadrant@example.com'
        );

        $otherEncadrant = $this->createEncadrant(
            $otherEntreprise,
            'other-encadrant@example.com'
        );

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.broadcastToEncadrants'),
                [
                    'titre' => 'Company announcement',
                    'message' => 'Message for our team.',
                ]
            );

        $response->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'id_Utilisateur' => $ownEncadrant->id,
            'titre' => 'Company announcement',
        ]);

        $this->assertDatabaseMissing('notifications', [
            'id_Utilisateur' => $otherEncadrant->id,
            'titre' => 'Company announcement',
        ]);

        $this->assertDatabaseCount('notifications', 1);
    }

    public function test_broadcast_fails_when_enterprise_has_no_encadrants(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.broadcastToEncadrants'),
                [
                    'titre' => 'Announcement',
                    'message' => 'No supervisors available.',
                ]
            );

        $response->assertRedirect();

        $response->assertSessionHasErrors([
            'broadcast',
        ]);

        $this->assertDatabaseCount('notifications', 0);
    }

    public function test_broadcast_requires_valid_data(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $response = $this
            ->actingAs($entreprise)
            ->post(
                route('entreprise.notifications.broadcastToEncadrants'),
                []
            );

        $response->assertSessionHasErrors([
            'titre',
            'message',
        ]);
    }

    public function test_entreprise_can_delete_its_own_notification(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $notification = $this->createNotification(
            $entreprise,
            false,
            'Notification to delete'
        );

        $response = $this
            ->actingAs($entreprise)
            ->delete(
                route(
                    'entreprise.notifications.destroy',
                    $notification->id
                )
            );

        $response->assertRedirect();

        $response->assertSessionHas(
            'message',
            'Notification deleted successfully.'
        );

        $this->assertSoftDeleted('notifications', [
            'id' => $notification->id,
        ]);
    }

    public function test_entreprise_cannot_delete_another_users_notification(): void
    {
        $entreprise = $this->createEntreprise('company@example.com');

        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'role' => 'Entreprise',
        ]);

        $notification = $this->createNotification(
            $otherUser,
            false,
            'Protected notification'
        );

        $response = $this
            ->actingAs($entreprise)
            ->delete(
                route(
                    'entreprise.notifications.destroy',
                    $notification->id
                )
            );

        $response->assertNotFound();

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'id_Utilisateur' => $otherUser->id,
            'deleted_at' => null,
        ]);
    }
}