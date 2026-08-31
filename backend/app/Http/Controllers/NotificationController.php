<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    // =========================================================================
    // 1. NORMAL USER / STAGIAIRE METHODS //GET ALL MESSAGES-MASK AS READ-MASK ALL READ
    // =========================================================================

     //Display the notification listing page.
     
    public function index()
    {
        $notifications = Notification::where('id_Utilisateur', Auth::id())
            ->orderBy('date_envoi', 'desc')
            ->get();

        return Inertia::render('Villes/Index', [
            'notifications' => $notifications,
        ]);
    }

      //Mark a single notification as read.

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('id_Utilisateur', Auth::id())
            ->firstOrFail();

        $notification->update(['lu' => true]);

        return back()->with('message', 'Notification marquée comme lue.');
    }

      //Mark all notifications for the authenticated user as read.
    public function markAllAsRead()
    {
        Notification::where('id_Utilisateur', Auth::id())
            ->where('lu', false)
            ->update(['lu' => true]);

        return back()->with('message', 'Toutes les notifications ont été marquées comme lues.');
    }
}