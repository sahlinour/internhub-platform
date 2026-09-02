<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Send a targeted notification to a single specific user.
     */
    public function indexAll(){

        $notifications = Notification::orderBy('date_envoi', 'desc')->get();
        return  Inertia::render('Admin/Notifications/indexAll', [
            'notifications' => $notifications,
        ]);
    }


    public function sendToUser(Request $request)
    {
        $request->validate([
            'id_Utilisateur' => 'required|exists:utilisateur,id',
            'titre'          => 'required|string|max:255',
            'message'        => 'required|string',
        ]);

        Notification::create([
            'titre'          => $request->titre,
            'message'        => $request->message,
            'lu'             => false,
            'date_envoi'     => now(),
            'id_Utilisateur' => $request->id_Utilisateur,
        ]);

        return back()->with('message', 'Notification sent to recipient.');
    }

    /**
     * Broadcast a notification to all registered users (or filtered by role).
     */
    public function broadcast(Request $request)
    {
        $request->validate([
            'titre'   => 'required|string|max:255',
            'message' => 'required|string',
            'role'    => 'nullable|string|in:stagiaire,encadrant,entreprise',
        ]);

        $query = Utilisateur::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $userIds = $query->pluck('id');
        $now = now();

        $notifications = $userIds->map(fn ($id) => [
            'titre'          => $request->titre,
            'message'        => $request->message,
            'lu'             => false,
            'date_envoi'     => $now,
            'id_Utilisateur' => $id,
        ])->toArray();

        Notification::insert($notifications);

        return back()->with('message', 'Notification delivered successfully.');
    }

    /**
     * Force delete any notification from the system.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return back()->with('message', 'Notification removed from the system.');
    }
}