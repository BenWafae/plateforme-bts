@extends('layouts.professeur')

@section('title', 'Mes Notifications')

@section('content')
<div class="container">
    <h2 class="mb-4">Mes Notifications</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($notifications->isEmpty())
        <div class="alert alert-info">
            Vous n'avez aucune notification pour le moment.
        </div>
    @else
        <div class="list-group">
            @foreach($notifications as $notification)
                <a href="{{ route('notifications.markAsRead', $notification->id_notification) }}" 
                   class="list-group-item list-group-item-action {{ $notification->lue ? 'list-group-item-light' : 'list-group-item-warning' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $notification->type === 'consultation_support' ? 'Consultation de support' : 'Téléchargement de support' }}</h5>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $notification->contenu }}</p>
                    <small class="text-muted">Statut : {{ $notification->lue ? 'Lue' : 'Non lue' }}</small>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
