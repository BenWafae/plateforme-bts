@extends('layouts.navbar')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary fw-bold">Détail de la notification</h2>

    <div class="card shadow-sm rounded-4 mb-5 border-0" style="border-left: 6px solid #7879E3;">
        <div class="card-body">
            <h5 class="card-title text-purple fw-bold" style="color: #5E60CE;">{{ $notification->alertTitle }}</h5>
            <p><strong>Date :</strong> <span class="text-muted">{{ $notification->created_at->format('d-m-Y H:i') }}</span></p>
            <p><strong>Type :</strong> <span class="text-muted">{{ $notification->type }}</span></p>
            <p><strong>Contenu :</strong></p>
            <p class="fs-5">{{ $notification->contenu }}</p>
        </div>
    </div>

  {{-- Gestion de la question --}}
@if($notification->type !== 'nouveau_support')
    @if(!$question)
        @if($notification->type === 'SuppressionDeQuestion')
            <div class="alert alert-danger rounded-4 shadow-sm">
                <strong>Cette question n'est plus accessible.</strong> Elle a été supprimée du système.
            </div>
        @else
            <div class="alert alert-warning rounded-4 shadow-sm">
                <strong>Question non trouvée.</strong> Elle peut avoir été supprimée.
            </div>
        @endif
    @else
        <div class="card mb-4 shadow-sm rounded-4 border" style="border-left: 6px solid #7879E3;">
            <div class="card-header bg-purple text-white rounded-top" style="background-color: #7879E3;">
                <h5 class="mb-0 fw-bold">Question associée</h5>
            </div>
            <div class="card-body">
                <p><strong>Titre :</strong> <span class="fw-semibold">{{ $question->titre }}</span></p>
                <p><strong>Contenu :</strong> {{ $question->contenue }}</p>
                <p><strong>Posée par :</strong> {{ $question->user->prenom ?? '' }} {{ $question->user->nom ?? '' }}</p>
            </div>
        </div>
    @endif
@endif


    {{-- Gestion de la réponse --}}
    @if($reponse && $question)
        <div class="card shadow-sm rounded-4 border" style="border-left: 6px solid #5E60CE;">
            <div class="card-header bg-purple text-white rounded-top" style="background-color: #5E60CE;">
                <h5 class="mb-0 fw-bold">Réponse associée</h5>
            </div>
            <div class="card-body bg-light rounded-bottom">
                <p class="fs-6">{{ $reponse->contenu }}</p>
                <p class="text-muted small mb-0">— par {{ $reponse->user->prenom ?? '' }} {{ $reponse->user->nom ?? '' }}</p>
                <p class="text-muted small">le {{ $reponse->created_at->format('d-m-Y H:i') }}</p>
            </div>
        </div>
    @else
        @if($question) 
            <p class="text-muted fst-italic">Aucune réponse associée à cette notification.</p>
        @endif
    @endif
  {{-- Affichage du support éducatif lié à la notification --}}
@if($notification->type === 'nouveau_support' && $support)
    <div class="card shadow-sm rounded-4 border mt-4" style="border-left: 6px solid #7879E3;">
        <div class="card-header" style="background-color: #7879E3; color: white;" >
            <h5 class="mb-0 fw-bold">Support éducatif associé</h5>
        </div>
        <div class="card-body">
            <p><strong>Titre :</strong> {{ $support->titre }}</p>
            <p><strong>Description :</strong> {{ $support->description }}</p>
            <p><strong>Format :</strong> {{ $support->format }}</p>

            @if(strpos($support->format, 'pdf') !== false)
                <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                   class="btn btn-outline-danger btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Voir PDF
                </a>

            @elseif(strpos($support->format, 'ppt') !== false)
                <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                   class="btn btn-outline-warning btn-sm" target="_blank">
                    <i class="fas fa-file-powerpoint"></i> Télécharger PPT
                </a>

            @elseif(strpos($support->format, 'word') !== false || strpos($support->format, 'doc') !== false)
                <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                   class="btn btn-outline-primary btn-sm" target="_blank">
                    <i class="fas fa-file-word"></i> Télécharger Word
                </a>

            @elseif(strpos($support->format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                <a href="{{ $support->lien_url }}" 
                   class="btn btn-outline-success btn-sm" target="_blank">
                    <i class="fas fa-video"></i> Regarder la vidéo
                </a>
            @endif
        </div>
    </div>
@endif




    <div class="mt-4">
        <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary rounded-pill">
            ← Retour aux notifications
        </a>
    </div>
</div>
@endsection
