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
                    'App\Notifications\QuestionPosee' => ['title' => 'Question posée', 'class' => 'alert-info'],
                    'App\Notifications\QuestionSupprimee' => ['title' => 'Question supprimée', 'class' => 'alert-danger'],
                    'App\Notifications\ReponseAjoutee' => ['title' => 'Réponse ajoutée', 'class' => 'alert-success'],
                    'default' => ['title' => 'Notification', 'class' => 'alert-secondary'],
                ];

                $type = $typesNotification[$notification->type] ?? $typesNotification['default'];
            @endphp

            <a href="{{ route('notifications.detail', $notification->id_notification) }}" class="text-decoration-none text-dark">
                <div class="alert {{ $notification->lue ? 'alert-light' : 'alert-success' }} alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                    <div class="d-flex align-items-center">
                        @if($notification->type == 'App\Notifications\QuestionPosee')
                            <i class="fas fa-question-circle me-2"></i>
                        @elseif($notification->type == 'App\Notifications\QuestionSupprimee')
                            <i class="fas fa-trash-alt me-2"></i>
                        @elseif($notification->type == 'App\Notifications\ReponseAjoutee')
                            <i class="fas fa-comment-dots me-2"></i>
                        @else
                            <i class="fas fa-bell me-2"></i>
                        @endif

                        <div>
                            <strong>{{ $type['title'] }}</strong>
                            <p class="mb-0">{{ $notification->contenu ?? 'Détails non disponibles' }}</p>
                            <small class="text-muted">
                                {{ optional($notification->created_at)->format('d/m/Y H:i') ?? 'Date inconnue' }}
                            </small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </a>
        @endforeach
    @endif
</div>
@endsection
