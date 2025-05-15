@extends('layouts.admin')

@section('title', 'Détails du Signalement')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="mb-4">Détail du Signalement</h2>

        <div class="mb-3">
            <strong>Type de contenu :</strong> <span class="text-primary">{{ ucfirst($report->content_type) }}</span>
        </div>
        <div class="mb-3">
            <strong>Raison :</strong> {{ $report->reason }}
        </div>
        <div class="mb-3">
            <strong>Description :</strong> {{ $report->description ?? 'Aucune' }}
        </div>
        <div class="mb-3">
            <strong>Statut :</strong> 
            <span class="badge bg-{{ $report->status === 'resolu' ? 'success' : ($report->status === 'rejete' ? 'danger' : 'warning') }}">
                {{ ucfirst($report->status) }}
            </span>
        </div>
        <div class="mb-4">
            <strong>Signalé par :</strong> {{ $report->user->prenom ?? '' }} {{ $report->user->nom ?? 'Utilisateur inconnu' }}
        </div>

        {{-- Afficher uniquement les signalements de questions --}}
        @if ($report->question)
            <div class="border-top pt-3">
                <h4 class="mb-3">Question Signalée</h4>
                <div class="alert alert-info">
                    <strong>Titre :</strong> {{ $report->question->titre }}<br>
                    <strong>Contenu :</strong> {{ $report->question->contenue }}
                </div>
            </div>
        @endif

        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection
