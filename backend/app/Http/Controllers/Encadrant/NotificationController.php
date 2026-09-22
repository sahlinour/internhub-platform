<?php

namespace App\Http\Controllers\Encadrant;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    
    public function index(): Response
    {
        $notifications = Notification::where('id_Utilisateur', Auth::id())
            ->orderByDesc('date_envoi')
            ->get();

        $unreadCount = Notification::where('id_Utilisateur', Auth::id())
            ->where('lu', false)
            ->count();

        return Inertia::render('Encadrant/Notifications/Index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }


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


    public function markAllAsRead(): RedirectResponse
    {
        Notification::where('id_Utilisateur', Auth::id())
            ->where('lu', false)
            ->update([
                'lu' => true,
            ]);

        return back();
    }


    public function destroy(int $id): RedirectResponse
    {
        $notification = Notification::where('id', $id)
            ->where('id_Utilisateur', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return back();
    }
}
