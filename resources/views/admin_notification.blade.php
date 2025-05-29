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
                    $isRead = $notification->lue;

                    // Définir le titre basé sur le type
                    if ($notification->type === 'nouvelle_question') {
                        $title = 'Nouvelle question posée';
                    } elseif ($notification->type === 'question_signalée') {
                        $title = 'Question signalée';
                    } else {
                        $title = 'Autre notification';
                    }

                    // Classes CSS : toutes blanches, gras si non lue
                    $itemClass = $isRead ? 'notification-read' : 'notification-unread fw-bold';
                @endphp

                <div class="mb-3">
                    <a href="{{ route('admin.notifications.readAndRedirect', $notification->id_notification) }}" 
                       class="list-group-item list-group-item-action {{ $itemClass }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $title }}</h5>
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
            background-color: #ffffff !important;
            border: 1px solid #ddd;
            color: #343a40;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        .notification-unread {
            font-weight: 600;
        }

        .notification-read {
            font-weight: normal;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .fw-bold {
            font-weight: bold !important;
        }
    </style>
@endsection
