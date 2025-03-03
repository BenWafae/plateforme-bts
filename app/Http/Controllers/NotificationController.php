<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Affiche la liste des notifications pour le professeur connecté
    public function index()
    {
        // Vérifie que seul un professeur peut voir ses notifications
        if (Auth::user()->role !== 'professeur') {
            abort(403, "Vous n'avez pas l'autorisation d'accéder aux notifications.");
        }

        // Récupère les notifications pour le professeur connecté
        $notifications = Notification::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications_index', compact('notifications'));
    }

    // Marquer une notification comme lue (quand le professeur clique dessus)
    public function markAsRead($id_notification)
    {
        if (Auth::user()->role !== 'professeur') {
            abort(403, "Vous n'avez pas l'autorisation de marquer cette notification comme lue.");
        }

        $notification = Notification::where('id_notification', $id_notification)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $notification->update(['lue' => true]);

        return redirect()->route('notifications.index')->with('success', 'Notification marquée comme lue.');
    }

    // Méthode pour afficher une notification individuelle (optionnelle)
    // public function show($id_notification)
    // {
    //     if (Auth::user()->role !== 'professeur') {
    //         abort(403, "Vous n'avez pas l'autorisation d'accéder à cette notification.");
    //     }

    //     $notification = Notification::where('id_notification', $id_notification)
    //         ->where('id_user', Auth::id())
    //         ->firstOrFail();

    //     return view('notifications_show', compact('notification'));
    // }
}
