@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-bell-fill"></i> Notifications Admin</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($notifications->isEmpty())
        <div class="alert alert-info">Aucune notification liée aux questions pour le moment.</div>
    @else
        <div class="list-group">
            @foreach($notifications as $notification)
                @php
                    // Vérification si la notification est lue ou non
                    $isRead = $notification->lue;
                    
                    // Déterminer la classe et le titre en fonction du type de notification
                    if ($notification->type === 'nouvelle_question') {
                        $typeClass = 'bg-info'; // Bleu pour les nouvelles questions
                        $title = 'Nouvelle question posée';
                    } elseif ($notification->type === 'question_signalée') {
                        $typeClass = 'bg-danger'; // Rouge pour les questions signalées
                        $title = 'Question signalée';
                    } else {
                        // Par défaut, on peut utiliser un autre type de couleur
                        $typeClass = 'bg-secondary';
                        $title = 'Autre notification';
                    }

                    // Classe pour notifications lues (fond blanc) et non lues (fond coloré)
                    $statusClass = $isRead ? 'bg-white text-dark' : $typeClass;
                @endphp

                <div class="mb-3">
                    <a href="{{ route('admin.notifications.readAndRedirect', $notification->id_notification) }}" 
                       class="list-group-item list-group-item-action {{ $statusClass }} {{ !$isRead ? 'text-white' : 'border' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                {{ $title }}
                            </h5>
                            <small>{{ \Carbon\Carbon::parse($notification->date_notification)->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $notification->contenu }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('styles')
    @parent
    <style>
        .list-group-item {
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .bg-white {
            background-color: #ffffff !important;
            border: 1px solid #ddd;
        }

        .text-dark {
            color: #343a40 !important;
        }

        .list-group-item .mb-1 {
            font-size: 1rem;
        }

        .text-white {
            color: #ffffff !important;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .border {
            border: 1px solid #ccc;
        }
    </style>
@endsection
