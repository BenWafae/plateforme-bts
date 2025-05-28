<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Reponse;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher la liste des notifications non lues.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('id_user', $user->id_user)
            ->orderBy('lue', 'asc') // Les notifications non lues en premier
            ->orderBy('created_at', 'desc') // Tri par date
            ->get();

        // Ajouter des classes CSS pour l'affichage des alertes
        $notifications->transform(function ($notification) {
            $notification->alertClass = $this->getAlertClass($notification->type);
            $notification->alertTitle = $this->getAlertTitle($notification->type);
            return $notification;
        });

        return view('notification_etudiants', compact('notifications'));
    }

    /**
     * Afficher les détails d'une notification.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        // Charger la notification avec ses relations (reponse.user et question.user)
       $notification = Notification::with(['reponse.user', 'question.user', 'support'])->findOrFail($id);

        // Marquer la notification comme lue si elle ne l'est pas déjà
        if (!$notification->lue) {
            $notification->lue = true;
            $notification->save();
        }

       $reponse = $notification->reponse;
     $question = $notification->question;
     $support = $notification->support;

return view('notification_detail', compact('notification', 'reponse', 'question', 'support'));

    }

    /**
     * Marquer une notification comme lue.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function marquerCommeLue($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->lue = true;
            $notification->save();
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Marquer toutes les notifications comme lues.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function marquerToutesCommeLues()
    {
        Auth::user()->notificationsNonLues()->update(['lue' => true]);

        return redirect()->route('notifications.index')->with('success', 'Toutes les notifications sont marquées comme lues.');
    }

    /**
     * Compter les notifications non lues de l'utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function count()
    {
        $user = auth()->user();
        $count = Notification::where('id_user', $user->id_user)->where('lue', false)->count();

        return view('navbar', compact('count'));
    }

    /**
     * Créer une notification pour une réponse donnée.
     *
     * @param  int  $reponseId
     * @return \Illuminate\Http\Response
     */
   public function storeReponse(Request $request, $questionId)
{
    // 1. Créer la réponse
    $reponse = Reponse::create([
        'contenu' => $request->contenu,
        'id_user' => auth()->id(),  // L'utilisateur qui répond
        'id_question' => $questionId,
    ]);

    // 2. Créer une notification pour l'utilisateur concerné (si besoin)
    $notification = Notification::create([
        'type' => 'Réponse',
        'contenu' => 'Votre question a reçu une réponse.',
        'lue' => false,
        'id_user' => $request->id_user, // L'utilisateur qui reçoit la notification
        'id_question' => $questionId, // ID de la question
        'date_notification' => now(),
    ]);

    // 3. Mettre à jour la notification avec id_reponse
    // Cette étape garantit que id_reponse est bien attribué à la notification
    $notification->update(['id_reponse' => $reponse->id]);

    // Retourner à la vue ou autre action
    return redirect()->route('questions.show', $questionId);
}





    /**
     * Retourne la classe d'alerte en fonction du type de notification.
     *
     * @param  string  $type
     * @return string
     */
    private function getAlertClass($type)
    {
        return match ($type) {
            'EnregistrementDeQuestion' => 'alert-success',
            'SuppressionDeQuestion' => 'alert-danger',
            'ReponseAUneQuestion' => 'alert-info',
            default => 'alert-primary',
        };
    }

    /**
     * Retourne le titre d'alerte en fonction du type de notification.
     *
     * @param  string  $type
     * @return string
     */
    private function getAlertTitle($type)
    {
        return match ($type) {
            'EnregistrementDeQuestion' => 'Nouvelle Question Enregistrée',
            'SuppressionDeQuestion' => 'Question Supprimée',
            'ReponseAUneQuestion' => 'Nouvelle Réponse',
            'nouveau_support' => 'Nouveau Support Éducatif',
            default => 'Notification',
        };
    }
}
