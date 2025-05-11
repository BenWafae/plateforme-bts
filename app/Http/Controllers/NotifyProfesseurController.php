<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotifyProfesseurController extends Controller
{


    public function notifications()
    {
        if (auth()->user()->role !== 'professeur') {
            abort(403, 'Accès interdit');
        }

        $professeurId = auth()->user()->id_user;

        $notifications = Notification::where('id_user', $professeurId)
            ->latest('date_notification')
            ->get();

        // ❗ Compteur mis à jour correctement avec condition lue = false
        $unreadNotificationsCount = Notification::where('id_user', $professeurId)
            ->where('lue', false)
            ->count();

        return view('professeur_notifications', compact('notifications', 'unreadNotificationsCount'));
    }

    public function markAsRead($id)
    {
        //  findOrFail utilisera maintenant id_notification comme clé primaire
        $notification = Notification::findOrFail($id);

        $notification->lue = true;
        $notification->save();

           return redirect()->route('professeur.questions.show', ['id' => $notification->id_question]);
    }

}