<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupérer les notifications de l'utilisateur
        $notifications = Notification::where('id_user', $user->id_user)
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

    private function getAlertClass($type)
    {
        return match ($type) {
            'App\Notifications\EnregistrementDeQuestion' => 'alert-success',
            'App\Notifications\SuppressionDeQuestion' => 'alert-danger',
            'App\Notifications\ReponseAUneQuestion' => 'alert-info',
            default => 'alert-primary',
        };
    }

    private function getAlertTitle($type)
    {
        return match ($type) {
            'App\Notifications\EnregistrementDeQuestion' => 'Nouvelle Question Enregistrée',
            'App\Notifications\SuppressionDeQuestion' => 'Question Supprimée',
            'App\Notifications\ReponseAUneQuestion' => 'Nouvelle Réponse',
            default => 'Notification',
        };
    }
}