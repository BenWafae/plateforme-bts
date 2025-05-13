@extends('layouts.navbar')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Détail de la notification</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ $notification->alertTitle }}</h5>
            <p><strong>Date :</strong> {{ $notification->created_at->format('d-m-Y H:i') }}</p>
            <p><strong>Type :</strong> {{ $notification->type }}</p>
            <p><strong>Contenu :</strong> {{ $notification->contenu }}</p>
        </div>
    </div>

    {{-- Gestion de la question --}}
    @if(!$question)
        @if($notification->type === 'SuppressionDeQuestion')
            <div class="alert alert-danger">
                <strong>Cette question n'est plus accessible.</strong> Elle a été supprimée du système.
            </div>
        @else
            <div class="alert alert-warning">
                <strong>Question non trouvée.</strong> Elle peut avoir été supprimée ou n'a jamais existé.
            </div>
        @endif
    @else
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Question associée</h5>
            </div>
            <div class="card-body">
                <p><strong>Titre :</strong> {{ $question->titre }}</p>
                <p><strong>Contenu :</strong> {{ $question->contenue }}</p>
                <p><strong>Posée par :</strong> {{ $question->user->prenom ?? '' }} {{ $question->user->nom ?? '' }}</p>
            </div>
        </div>
    @endif

    {{-- Gestion de la réponse --}}
    @if($reponse && $question)
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Réponse associée</h5>
            </div>
            <div class="card-body bg-light">
                <p>{{ $reponse->contenu }}</p>
                <p class="text-muted small mb-0">— par {{ $reponse->user->prenom ?? '' }} {{ $reponse->user->nom ?? '' }}</p>
                <p class="text-muted small">le {{ $reponse->created_at->format('d-m-Y H:i') }}</p>
            </div>
        </div>
    @else
        @if($question) 
            <p class="text-muted">Aucune réponse associée à cette notification.</p>
        @endif
    @endif

    <div class="mt-4">
        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">← Retour aux notifications</a>
    </div>
</div>
@endsection
