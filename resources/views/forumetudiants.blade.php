@extends('layouts.sidbar') <!-- Étendre le layout principal contenant la sidebar -->

@section('title', 'Forum Etudiants') <!-- Spécifier le titre de la page -->

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Forum Etudiants (Questions & Réponses)</h2>

        <!-- Bouton pour poser une nouvelle question, redirige vers la page de création -->
        <div class="mb-4">
            <a href="{{ route('questions.create') }}" class="btn btn-primary">Poser une nouvelle question</a>
        </div>

        <!-- Formulaire de recherche -->
        <form action="{{ route('forumetudiants.index') }}" method="GET" class="mb-4">
            <div class="row">
                <!-- Champ de recherche pour le titre -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Rechercher une question..." value="{{ request('search') }}">
                </div>
                <!-- Sélecteur pour la matière -->
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
                <!-- Sélecteur pour la date -->
                <div class="col-md-4">
                    <input type="date" class="form-control" name="date" value="{{ request('date') }}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
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
            <div class="card-header">Vos Questions et Réponses</div>
            <div class="card-body">
                @if($questions->isEmpty())
                    <p class="text-muted">Aucune question posée pour le moment.</p>
                @else
                    @foreach($questions as $question)
                        <div class="mb-4">
                            <!-- Affichage du titre de la question -->
                            <h5>{{ $question->titre }}</h5> <!-- Le titre de la question -->
                            

                            <!-- Affichage du contenu de la question -->
                            <p>{{ $question->contenue }}</p>
                            
                            <!-- Affichage des informations sur la question -->
                            <p class="text-muted">Posté par {{ $question->user->nom }} {{ $question->user->prenom }} le {{ $question->created_at->format('d/m/Y à H:i') }}</p>
                            <p><strong>Matière :</strong> {{ $question->matiere->Nom }}</p>
                            
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
