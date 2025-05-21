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
            // latest utiliser pour trier les notification par date de plus recent 
            ->get();

           

        //  Ccompter les notifications non luee
        $unreadNotificationsCount = Notification::where('id_user', $professeurId)
            ->where('lue', false)
            ->count();
        //   unreadnotiifiication a pour but de trnsfer le nbr de notification non lue
        return view('professeur_notifications', compact('notifications', 'unreadNotificationsCount'));
    }

    public function markAsRead($id)
    {
        //  findOrFail utiliser pour trouvee une notiifiication par id s elle existe il est recuperer sinon envoie un erreur
        $notification = Notification::findOrFail($id);
            //  on miiis  a jouur le champs lus de faalse a trueee 
        $notification->lue = true;
        $notification->save();
        // la modification est enregistrerr dans la base de donneee

           return redirect()->route('professeur.questions.show', ['id' => $notification->id_question]);
    }

}