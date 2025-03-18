<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les notifications non lues en priorité, puis les lues
        $notifications = Notification::where('id_user', $user->id_user)
            ->orderBy('lue', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ajouter la classe d'alerte et le titre pour chaque notification
        $notifications->transform(function ($notification) {
            $notification->alertClass = $this->getAlertClass($notification->type);
            $notification->alertTitle = $this->getAlertTitle($notification->type);
            return $notification;
        });

        return view('notification_etudiants', compact('notifications'));
    }


    public function marquerCommeLue($id)
    {
        $notification = Notification::find($id);
        
        if ($notification) {
            $notification->lue = true;
            $notification->save();
        }
    
        return redirect()->route('notifications.index');
    }
    
    public function marquerToutesCommeLues()
    {
        Auth::user()->notificationsNonLues()->update(['lue' => true]);

        return redirect()->route('notifications.index')->with('success', 'Toutes les notifications sont marquées comme lues.');
    }

    public function count()
{
    $user = auth()->user();
    $count = Notification::where('id_user', $user->id_user)->where('lue', false)->count();
    
    return view('navbar', compact('count')); // Envoyer la variable à la navbar
}

    private function getAlertClass($type)
    {
        return match ($type) {
            'EnregistrementDeQuestion' => 'alert-success',
            'SuppressionDeQuestion' => 'alert-danger',
            'ReponseAUneQuestion' => 'alert-info',
            default => 'alert-primary',
        };
    }

    private function getAlertTitle($type)
    {
        return match ($type) {
            'EnregistrementDeQuestion' => 'Nouvelle Question Enregistrée',
            'SuppressionDeQuestion' => 'Question Supprimée',
            'ReponseAUneQuestion' => 'Nouvelle Réponse',
            default => 'Notification',
        };
    }
}