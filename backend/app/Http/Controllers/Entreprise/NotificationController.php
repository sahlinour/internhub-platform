<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Encadrant;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Send a notification to a single Encadrant assigned to this Entreprise.
     */
    public function sendToEncadrant(Request $request)
    {
        $request->validate([
            'id_Utilisateur' => 'required|exists:users,id',
            'titre'          => 'required|string|max:255',
            'message'        => 'required|string',
        ]);

        $authUserId = Auth::id();

        // Verify the recipient encadrant belongs to this entreprise
        $isMyEncadrant = Encadrant::where('user_id', $request->id_Utilisateur)
            ->where('entreprise_id', $authUserId)
            ->exists();

        if (!$isMyEncadrant) {
            return back()->withErrors([
                'id_Utilisateur' => 'You can only send notifications to encadrants attached to your enterprise.',
            ]);
        }

        Notification::create([
            'titre'          => $request->titre,
            'message'        => $request->message,
            'lu'             => false,
            'date_envoi'     => now(),
            'id_Utilisateur' => $request->id_Utilisateur,
        ]);

        return back()->with('message', 'Notification sent to the framework successfully.');
    }

    /**
     * Broadcast a notification to ALL encadrants belonging to this Entreprise.
     */
    public function broadcastToEncadrants(Request $request)
    {
        $request->validate([
            'titre'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $authUserId = Auth::id();

        // Fetch all user_ids of encadrants assigned to this company
        $encadrantUserIds = Encadrant::where('entreprise_id', $authUserId)->pluck('user_id');

        if ($encadrantUserIds->isEmpty()) {
            return back()->withErrors([
                'broadcast' => 'No encadrants are currently attached to your enterprise.',
            ]);
        }

        $now = now();

        $notifications = $encadrantUserIds->map(fn ($userId) => [
            'titre'          => $request->titre,
            'message'        => $request->message,
            'lu'             => false,
            'date_envoi'     => $now,
            'id_Utilisateur' => $userId,
        ])->toArray();

        // Bulk insert notifications for all company encadrants
        Notification::insert($notifications);

        return back()->with('message', 'Notification broadcast to all your encadrants.');
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return back()->with('message', 'Notification deleted successfully.');
    }
}