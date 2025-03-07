@extends('layouts.sidbar') <!-- Étendre le layout principal contenant la sidebar -->

@section('title', 'Messages') <!-- Spécifier le titre de la page -->

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Messages (Questions & Réponses)</h2>

        <!-- Affichage des messages de succès -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire pour poser une question -->
        <div class="card mb-4">
            <div class="card-header">Poser une nouvelle question</div>
            <div class="card-body">
                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre de la question :</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="contenue" class="form-label">Contenu :</label>
                        <textarea class="form-control" id="contenue" name="contenue" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>

        <!-- Liste des questions et réponses -->
        <div class="card">
            <div class="card-header">Vos Questions et Réponses</div>
            <div class="card-body">
                @if($questions->isEmpty())
                    <p class="text-muted">Aucune question posée pour le moment.</p>
                @else
                    @foreach($questions as $question)
                        <div class="mb-4">
                            <h5>{{ $question->titre }}</h5>
                            <p>{{ $question->contenue }}</p>
                            <p class="text-muted">Posté par {{ $question->user->nom }} {{ $question->user->prenom }} le {{ $question->created_at->format('d/m/Y à H:i') }}</p>
                            <!-- Suppression uniquement si l'utilisateur est l'auteur de la question -->
                            @if($question->id_user == Auth::id())
                                <form action="{{ route('questions.destroy', $question->id_question) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            @endif
                            <!-- Affichage des réponses -->
                            <div class="ms-4 mt-3">
                                <h6>Réponses :</h6>
                                @forelse($question->reponses as $reponse)
                                    <div>
                                        <p>{{ $reponse->contenu }}</p>
                                        <p class="text-muted">Répondu par {{ $reponse->user->nom }} {{ $reponse->user->prenom }} le {{ $reponse->created_at->format('d/m/Y à H:i') }}</p>
                                        
                                        <!-- Suppression uniquement si l'utilisateur est l'auteur de la réponse -->
                                        @if($reponse->id_user == Auth::id())
                                            <form action="{{ route('reponse.destroy', $reponse->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <p>Aucune réponse pour cette question.</p>
                                @endforelse
                            </div>

                            <!-- Formulaire pour répondre -->
                            @if(Auth::check()) <!-- Afficher seulement si l'utilisateur est connecté -->
                                <div class="ms-4 mt-3">
                                    <h6>Répondre :</h6>
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
                @endif
            </div>
        </div>
    </div>
@endsection
