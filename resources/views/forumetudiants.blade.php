@extends('layouts.navbar') <!-- Étendre le layout principal contenant la sidebar -->

@section('title', 'Forum Etudiants')

@section('content') <div class="container mt-4"> <h2 class="mb-4">Forum Etudiants (Questions & Réponses)</h2>

<!-- Bouton pour poser une nouvelle question -->
    <div class="mb-4">
        <a href="{{ route('questions.create') }}" class="btn btn-primary">Poser une question</a>
    </div>

    <!-- Formulaire de recherche -->
    <form action="{{ route('forumetudiants.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" placeholder="Rechercher une question..." value="{{ request('search') }}">
            </div>

            <div class="col-md-4">
                <select class="form-control" name="id_Matiere">
                    <option value="">-- Choisir une matière --</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id_Matiere }}" {{ request('id_Matiere') == $matiere->id_Matiere ? 'selected' : '' }}>
                            {{ $matiere->Nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select class="form-control" name="year">
                    <option value="">-- Choisir une année --</option>
                    @for($year = 2020; $year <= now()->year; $year++)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Rechercher</button>
            </div>
        </div>
    </form>

    <!-- Affichage des messages de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Liste des questions et réponses -->
    <div class="card">
        <div class="card-header">
            <strong>Vos Questions et Réponses</strong>
        </div>
        <div class="card-body">
            @if($questions->isEmpty())
                <p class="text-muted">Aucune question posée pour le moment.</p>
            @else
                <div id="questions-container">
                    @foreach($questions as $question)
                        <div class="mb-4 question-item">
                            <h5>{{ $question->titre }}</h5>
                            <p>{{ $question->contenue }}</p>
                            <p class="text-muted">Posté par {{ $question->user->nom }} {{ $question->user->prenom }} le {{ $question->created_at->format('d/m/Y à H:i') }}</p>
                            <p><strong>Matière :</strong> {{ $question->matiere->Nom }}</p>

                            @if($question->id_user == Auth::id())
                                <form action="{{ route('questions.destroy', $question->id_question) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            @endif

                            <!-- Bouton "Signaler" pour la question -->
                            @if($question->id_user != Auth::id())
                                <button class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#reportModal{{ $question->id_question }}">
                                    <i class="fas fa-exclamation-triangle"></i> Signaler
                                </button>
                            @endif

                            <!-- Modal Signalement pour la Question -->
                            <div class="modal fade" id="reportModal{{ $question->id_question }}" tabindex="-1" aria-labelledby="reportModalLabel{{ $question->id_question }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('reports.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="content_type" value="question">
                                            <input type="hidden" name="id_question" value="{{ $question->id_question }}">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="reportModalLabel{{ $question->id_question }}">Signaler cette question</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Motif</label>
                                                    <select class="form-select" name="reason" required>
                                                        <option value="">Sélectionner un motif</option>
                                                        <option value="inapproprié">Contenu inapproprié</option>
                                                        <option value="erroné">Contenu erroné</option>
                                                        <option value="autre">Autre</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Description (facultatif)</label>
                                                    <textarea name="description" class="form-control" rows="3" placeholder="Donnez plus de détails..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Envoyer</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Réponses -->
                            <div class="ms-4 mt-3">
                                <h6><strong>Réponses :</strong></h6>
                                @forelse($question->reponses as $reponse)
                                    <div>
                                        <p>{{ $reponse->contenu }}</p>
                                        <p class="text-muted">Répondu par {{ $reponse->user->nom }} {{ $reponse->user->prenom }} le {{ $reponse->created_at->format('d/m/Y à H:i') }}</p>

                                        @if($reponse->id_user == Auth::id())
                                            <form action="{{ route('reponse.destroy', $reponse->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        @endif

                                        <!-- Bouton "Signaler" pour la réponse -->
                                        @if($reponse->id_user != Auth::id())
                                            <button class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#reportModalReponse{{ $reponse->id }}">
                                                <i class="fas fa-exclamation-triangle"></i> Signaler
                                            </button>
                                        @endif

                                        <!-- Modal Signalement pour la Réponse -->
                                        <div class="modal fade" id="reportModalReponse{{ $reponse->id }}" tabindex="-1" aria-labelledby="reportModalLabelReponse{{ $reponse->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('reports.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="content_type" value="reponse">
                                                        <input type="hidden" name="id_reponse" value="{{ $reponse->id }}">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="reportModalLabelReponse{{ $reponse->id }}">Signaler cette réponse</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Motif</label>
                                                                <select class="form-select" name="reason" required>
                                                                    <option value="">Sélectionner un motif</option>
                                                                    <option value="inapproprié">Contenu inapproprié</option>
                                                                    <option value="erroné">Contenu erroné</option>
                                                                    <option value="autre">Autre</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Description (facultatif)</label>
                                                                <textarea name="description" class="form-control" rows="3" placeholder="Donnez plus de détails..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Envoyer</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>Aucune réponse pour cette question.</p>
                                @endforelse
                            </div>

                            @if(Auth::check())
                                <div class="ms-4 mt-3">
                                    <h6><strong>Répondre :</strong></h6>
                                    <form action="{{ route('reponse.store', $question->id_question) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_question" value="{{ $question->id_question }}">
                                        <div class="mb-3">
                                            <textarea class="form-control" name="contenu" rows="2" placeholder="Écrivez votre réponse ici..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm">Répondre</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <hr>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Bouton "Voir plus" -->
    @if($questions->hasMorePages())
        <div class="text-center mt-3">
            <a href="{{ $questions->nextPageUrl() }}" id="load-more" class="btn btn-secondary">Voir plus</a>
        </div>
    @endif
</div>

<!-- JS pour les modals Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection