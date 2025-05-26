@extends('layouts.navbar')

@section('title', 'Forum Étudiants')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold">Forum Étudiants</h2>

    <!-- Filtres -->
    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border">
        <form method="GET" action="{{ route('forumetudiants.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Recherche</label>
                <input type="text" class="form-control" name="search" placeholder="Mot-clé..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Matière</label>
                <select class="form-select" name="id_Matiere">
                    <option value="">Toutes les matières</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id_Matiere }}" {{ request('id_Matiere') == $matiere->id_Matiere ? 'selected' : '' }}>{{ $matiere->Nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Année</label>
                <select class="form-select" name="year">
                    <option value="">Toutes les années</option>
                    @for($year = 2020; $year <= now()->year; $year++)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100 rounded-pill">Filtrer</button>
            </div>
        </form>
    </div>

    <!-- Message flash -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    <!-- Liste des questions -->
    @forelse($questions as $question)
        <div class="bg-white border-start border-4 border-primary rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="fw-bold mb-2">{{ $question->titre }}</h5>
                    <p class="mb-2">{{ $question->contenue }}</p>
                    <div class="text-muted small">
                        Posté par <strong>{{ $question->user->nom }} {{ $question->user->prenom }}</strong> 
                        | {{ $question->created_at->format('d/m/Y à H:i') }} 
                        | <span class="badge bg-light text-dark border">{{ $question->matiere->Nom }}</span>
                    </div>
                </div>
                <div class="text-end">
                    @if($question->id_user == Auth::id())
                        <form action="{{ route('questions.destroy', $question->id_question) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm rounded-pill">Supprimer</button>
                        </form>
                    @else
                        <button class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#reportModal{{ $question->id_question }}">Signaler</button>
                    @endif
                </div>
            </div>

            <!-- Réponses -->
            @if($question->reponses->isNotEmpty())
                <div class="mt-4">
                    <h6 class="text-muted mb-3">Réponses ({{ $question->reponses->count() }})</h6>
                    @foreach($question->reponses as $reponse)
                        <div class="bg-light rounded-3 p-3 mb-2">
                            <p class="mb-1">{{ $reponse->contenu }}</p>
                            <div class="small text-muted">Par {{ $reponse->user->nom }} {{ $reponse->user->prenom }} le {{ $reponse->created_at->format('d/m/Y à H:i') }}</div>

                            @if($reponse->id_user == Auth::id())
                                <form action="{{ route('reponse.destroy', $reponse->id) }}" method="POST" class="mt-1">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Formulaire réponse -->
            @auth
                <form action="{{ route('reponse.store', $question->id_question) }}" method="POST" class="mt-3">
                    @csrf
                    <textarea class="form-control" name="contenu" rows="2" placeholder="Votre réponse..." required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm mt-2 rounded-pill">Répondre</button>
                </form>
            @endauth
        </div>

        <!-- Modal signalement -->
        <div class="modal fade" id="reportModal{{ $question->id_question }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="content_type" value="question">
                        <input type="hidden" name="id_question" value="{{ $question->id_question }}">
                        <div class="modal-header bg-light rounded-top">
                            <h5 class="modal-title">Signaler une question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Motif</label>
                            <select name="reason" class="form-select mb-3" required>
                                <option value="">Choisir un motif</option>
                                <option value="inapproprié">Contenu inapproprié</option>
                                <option value="erroné">Contenu erroné</option>
                                <option value="autre">Autre</option>
                            </select>
                            <label class="form-label">Détails (facultatif)</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="submit">Envoyer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">Aucune question pour le moment.</div>
    @endforelse

    <!-- Pagination -->
    @if($questions->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $questions->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection