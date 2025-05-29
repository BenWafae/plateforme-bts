@extends('layouts.navbar')

@section('content')
<div class="container mt-4">
    <h1>Vos Notifications</h1>

    @if($notifications->isEmpty())
        <div class="alert alert-info text-center">
            Aucune notification à afficher.
        </div>
    @else
        @foreach($notifications as $notification)
            @php
                $typesNotification = [
                    'App\Notifications\QuestionPosee' => ['title' => 'Question posée'],
                    'App\Notifications\QuestionSupprimee' => ['title' => 'Question supprimée'],
                    'App\Notifications\ReponseAjoutee' => ['title' => 'Réponse ajoutée'],
                    'default' => ['title' => 'Notification'],
                ];

                $type = $typesNotification[$notification->type] ?? $typesNotification['default'];
                $isRead = $notification->lue;
                $textClass = $isRead ? '' : 'fw-bold'; // Texte en gras si non lue
            @endphp

            <a href="{{ route('notifications.detail', $notification->id_notification) }}" class="text-decoration-none text-dark">
                <div class="alert alert-light border d-flex justify-content-between align-items-center" role="alert">
                    <div class="d-flex align-items-center w-100">
                        @if($notification->type == 'App\Notifications\QuestionPosee')
                            <i class="fas fa-question-circle me-2"></i>
                        @elseif($notification->type == 'App\Notifications\QuestionSupprimee')
                            <i class="fas fa-trash-alt me-2"></i>
                        @elseif($notification->type == 'App\Notifications\ReponseAjoutee')
                            <i class="fas fa-comment-dots me-2"></i>
                        @else
                            <i class="fas fa-bell me-2"></i>
                        @endif

                        <div class="{{ $textClass }}">
                            <div>{{ $type['title'] }}</div>
                            <p class="mb-0">{{ $notification->contenu ?? 'Détails non disponibles' }}</p>
                            <small class="text-muted">
                                {{ optional($notification->created_at)->format('d/m/Y H:i') ?? 'Date inconnue' }}
                            </small>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    @endif
</div>
@endsection
