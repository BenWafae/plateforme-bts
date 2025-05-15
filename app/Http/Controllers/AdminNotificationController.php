<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class AdminNotificationController extends Controller
{
    /**
     * Affiche les notifications de type 'nouvelle_question' et 'question_signalée',
     * avec le comptage des notifications non lues.
     */
    public function index()
    {
        // Récupérer les notifications de type 'nouvelle_question' ou 'question_signalée'
        $notifications = Notification::whereIn('type', ['nouvelle_question', 'question_signalée'])
            ->orderBy('date_notification', 'desc')
            ->get();

        // Compter les notifications non lues dans ces types
        $unreadCount = $notifications->where('lue', false)->count();

        // Passer les données à la vue
        return view('admin_notification', compact('notifications', 'unreadCount'));
         }

    /**
     * Marque une notification comme lue et redirige vers la question liée.
     */
    public function readAndRedirect($id)
{
    $notification = Notification::findOrFail($id);

    if (!$notification->lue) {
        $notification->lue = true;
        $notification->save();
    }

    if ($notification->id_question) {
        return redirect()->route('admin.questions.show', $notification->id_question);
    }

    return redirect()->route('admin.notifications.index')->with('success', 'Notification marquée comme lue.');
}


    /**
     * Marque toutes les notifications comme lues.
     */
    public function markAllAsRead()
    {
        Notification::whereIn('type', ['question_signalée', 'nouvelle_question'])
            ->update(['lue' => true]);

        return redirect()->route('admin.notifications.index')->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Marque une notification comme lue (sans redirection).
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['lue' => true]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification marquée comme lue.');
    }
}
