@extends('layouts.navbar')

@section('title', 'Forum Étudiants')

@section('content')

<style>
    .question-box {
        border-left: 6px solid #7879E3;
        border-radius: 12px;
        background-color: #fff;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .filter-box {
        border: 2px solid #7879E3;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .filter-box .filter-header {
        background-color: #7879E3;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
        font-size: 18px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    body {
        background-color: #f4f6fc;
    }
</style>

<div class="container py-5">
<!-- Carte de bienvenue -->
<div class="alert alert-info shadow-sm rounded-4 p-4 mb-4 d-flex align-items-start" style="background-color: #f0f4ff; border-left: 6px solid #7879E3;">
    <div class="me-3 fs-2 text-primary"></div>
    <div>
        <h5 class="fw-bold text-primary mb-1">Bienvenue sur le Forum des Étudiants</h5>
        <p class="mb-0">
            Ce forum est un espace d’échange entre étudiants et enseignants. 
            Posez vos questions sur les matières, les devoirs ou les examens, et recevez des réponses de vos camarades ou des professeurs. 
            Participez avec respect et bienveillance 
        </p>
    </div>
</div>
    <!-- Filtres -->
    <div class="filter-box">
        <div class="filter-header">🔍 Filtres de recherche</div>
        <div class="bg-white p-4">
            <form method="GET" action="{{ route('forumetudiants.index') }}" class="row g-3 align-items-end">
                <!-- Champs de recherche -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-search"></i> Recherche</label>
                    <input type="text" class="form-control rounded-3" name="search" placeholder="Mot-clé..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-book"></i> Matière</label>
                    <select class="form-select rounded-3" name="id_Matiere">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_Matiere }}" {{ request('id_Matiere') == $matiere->id_Matiere ? 'selected' : '' }}>{{ $matiere->Nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar"></i> Année</label>
                    <select class="form-select rounded-3" name="year">
                        <option value="">Toutes les années</option>
                        @for($year = 2020; $year <= now()->year; $year++)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill"><i class="bi bi-funnel-fill"></i> Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Message flash -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    <!-- Liste des questions -->
    @forelse($questions as $question)
        <div class="question-box">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold text-primary mb-2">{{ $question->titre }}</h5>
                    <p class="mb-2">{{ $question->contenue }}</p>
                    <div class="text-muted small">
                        Posté par <strong>{{ $question->user->nom }} {{ $question->user->prenom }}</strong> 
                        | {{ $question->created_at->format('d/m/Y à H:i') }} 
                        | <span class="badge bg-light text-dark border">{{ $question->matiere->Nom }}</span>
                    </div>
                </div>
                <div class="text-end ms-3">
                    @if($question->id_user == Auth::id())
                        <form action="{{ route('questions.destroy', $question->id_question) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    @else
                        <button class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#reportModal{{ $question->id_question }}">
                            <i class="bi bi-flag"></i> Signaler
                        </button>
                    @endif
                </div>
            </div>

            <!-- Réponses -->
            @if($question->reponses->isNotEmpty())
                <div class="mt-4">
                    <h6 class="text-muted mb-3"><i class="bi bi-chat-dots"></i> Réponses ({{ $question->reponses->count() }})</h6>
                    @foreach($question->reponses as $reponse)
                        <div class="bg-light rounded-3 p-3 mb-2">
                            <p class="mb-1">{{ $reponse->contenu }}</p>
                            <div class="small text-muted">Par {{ $reponse->user->nom }} {{ $reponse->user->prenom }} le {{ $reponse->created_at->format('d/m/Y à H:i') }}</div>
                            @if($reponse->id_user == Auth::id())
                                <form action="{{ route('reponse.destroy', $reponse->id) }}" method="POST" class="mt-1">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-x-circle"></i> Supprimer
                                    </button>
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
                    <textarea class="form-control rounded-3" name="contenu" rows="2" placeholder="Votre réponse..." required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm mt-2 rounded-pill"><i class="bi bi-send"></i> Répondre</button>
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
                            <h5 class="modal-title"><i class="bi bi-flag-fill text-danger me-2"></i>Signaler une question</h5>
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

   @if($questions->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                <div class="px-6 py-4">
                    {{ $questions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
