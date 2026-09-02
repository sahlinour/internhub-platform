<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the logged-in user/stagiaire.
     */
    public function index()
    {
        $notifications = Notification::where('id_Utilisateur', Auth::id())
            ->orderBy('date_envoi', 'desc')
            ->get();

        return Inertia::render('Stagiaire/Notifications/Index', [
            'notifications' => $notifications,
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