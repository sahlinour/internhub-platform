<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    /**
     * Display notifications of the authenticated Entreprise.
     */
    public function index(): Response
    {
        $notifications = Notification::where('id_Utilisateur', Auth::id())
            ->orderByDesc('date_envoi')
            ->get();

        $unreadCount = Notification::where('id_Utilisateur', Auth::id())
            ->where('lu', false)
            ->count();

        return Inertia::render('Entreprise/Notifications/Index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }


    /**
     * Mark one notification as read.
     */
    public function markAsRead(int $id): RedirectResponse
    {
        $notification = Notification::where('id', $id)
            ->where('id_Utilisateur', Auth::id())
            ->firstOrFail();

        $notification->update([
            'lu' => true,
        ]);

        return back();
    }


    /**
     * Mark all notifications of the authenticated Entreprise as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        Notification::where('id_Utilisateur', Auth::id())
            ->where('lu', false)
            ->update([
                'lu' => true,
            ]);

        return back();
    }


    /**
     * Send a notification to a single Encadrant
     * assigned to this Entreprise.
     */
    public function sendToEncadrant(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_Utilisateur' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'titre' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
            ],
        ]);

        $authUserId = Auth::id();

        /*
         * Verify that the selected Encadrant
         * belongs to the authenticated Entreprise.
         */
        $isMyEncadrant = Encadrant::where(
                'user_id',
                $validated['id_Utilisateur']
            )
            ->where('entreprise_id', $authUserId)
            ->exists();

        if (!$isMyEncadrant) {
            return back()->withErrors([
                'id_Utilisateur' =>
                    'You can only send notifications to encadrants attached to your enterprise.',
            ]);
        }

        Notification::create([
            'titre' => $validated['titre'],
            'message' => $validated['message'],
            'lu' => false,
            'date_envoi' => now(),
            'id_Utilisateur' => $validated['id_Utilisateur'],
        ]);

        return back()->with(
            'message',
            'Notification sent to the encadrant successfully.'
        );
    }


    /**
     * Broadcast a notification to all Encadrants
     * belonging to the authenticated Entreprise.
     */
    public function broadcastToEncadrants(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
            ],
        ]);

        $authUserId = Auth::id();

        /*
         * Get all Encadrant user IDs attached
         * to the authenticated Entreprise.
         */
        $encadrantUserIds = Encadrant::where(
                'entreprise_id',
                $authUserId
            )
            ->pluck('user_id');

        if ($encadrantUserIds->isEmpty()) {
            return back()->withErrors([
                'broadcast' =>
                    'No encadrants are currently attached to your enterprise.',
            ]);
        }

        $now = now();

        $notifications = $encadrantUserIds
            ->map(function ($userId) use ($validated, $now) {
                return [
                    'titre' => $validated['titre'],
                    'message' => $validated['message'],
                    'lu' => false,
                    'date_envoi' => $now,
                    'id_Utilisateur' => $userId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })
            ->toArray();

        Notification::insert($notifications);

        return back()->with(
            'message',
            'Notification broadcast to all your encadrants.'
        );
    }


    /**
     * Delete one notification belonging
     * to the authenticated Entreprise.
     */
    public function destroy(int $id): RedirectResponse
    {
        $notification = Notification::where('id', $id)
            ->where('id_Utilisateur', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return back()->with(
            'message',
            'Notification deleted successfully.'
        );
    }
}
