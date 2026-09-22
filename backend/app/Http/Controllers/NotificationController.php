<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the logged-in user/stagiaire.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Notification::where(
            'id_Utilisateur',
            Auth::id()
        );

        switch ($filter) {
            case 'unread':
                $query->where('lu', false);
                break;

            case 'read':
                $query->where('lu', true);
                break;

            case 'tasks':
                // À adapter selon la manière dont tes notifications
                // de tâches sont identifiées.
                $query->where(function ($q) {
                    $q->where('titre', 'like', '%task%')
                    ->orWhere('titre', 'like', '%tâche%')
                    ->orWhere('message', 'like', '%task%')
                    ->orWhere('message', 'like', '%tâche%');
                });
                break;

            case 'all':
            default:
                break;
        }

        $notifications = $query
            ->orderBy('date_envoi', 'desc')
            ->paginate(10)
            ->withQueryString();

        $unreadCount = Notification::where(
            'id_Utilisateur',
            Auth::id()
        )
            ->where('lu', false)
            ->count();

        return Inertia::render('Stagiaire/Notifications/Index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'currentFilter' => $filter,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('id_Utilisateur', Auth::id())
            ->firstOrFail();

        $notification->update(['lu' => true]);

        return back()->with('message', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read for the logged-in user.
     */
    public function markAllAsRead()
    {
        Notification::where('id_Utilisateur', Auth::id())
            ->where('lu', false)
            ->update(['lu' => true]);

        return back()->with('message', 'All notifications have been marked as read.');
    }

    /**
     * Delete a single notification for the logged-in user.
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('id_Utilisateur', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return back()->with('message', 'Notification deleted successfully.');
    }
}