<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Affiche la liste des notifications pour le professeur connecté
    public function index()
    {
        if (Auth::user()->role !== 'professeur') {
            abort(403, "Vous n'avez pas l'autorisation d'accéder aux notifications.");
        }
    
        // Marquer toutes les notifications non lues comme lues directement
        Notification::where('id_user', Auth::id())
            ->where('lue', false)
            ->update(['lue' => true]);
    
        // Récupère toutes les notifications après mise à jour
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
    public static function countUnreadNotifications()
{
    return Notification::where('id_user', Auth::id())
        ->where('lue', false)
        ->count();
}


}
