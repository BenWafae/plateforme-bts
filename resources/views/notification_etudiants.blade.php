@extends('layouts.navbar')

@section('content')
<div class="container">
    <h1>Vos Notifications</h1>

    @if($notifications->isEmpty())
        <div class="alert alert-info">
            Aucune notification à afficher.
        </div>
    @else
        @foreach($notifications as $notification)
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <!-- Affichage du titre en fonction du type de notification -->
                @if($notification->type == 'App\Notifications\QuestionPosee')
                    <strong>Question posée</strong>
                @elseif($notification->type == 'App\Notifications\QuestionSupprimee')
                    <strong>Question supprimée</strong>
                @elseif($notification->type == 'App\Notifications\ReponseAjoutee')
                    <strong>Réponse ajoutée</strong>
                @else
                    <strong>Notification</strong>
                @endif

                <!-- Contenu de la notification -->
                <p>{{ $notification->contenu ?? 'Détails non disponibles' }}</p>

                <!-- Affichage de la date de création -->
                <small class="text-muted">
                    {{ optional($notification->created_at)->diffForHumans() ?? 'Date inconnue' }}
                </small>

                <!-- Bouton pour fermer l'alerte -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
</div>
@endsection