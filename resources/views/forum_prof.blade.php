@extends('layouts.professeur')

@section('content')
    <h1>Liste des questions</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($questions as $question)
    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Posée par : </strong>{{ $question->user->nom }} {{ $question->user->prenom }}</p>
            <h5 class="card-title">{{ $question->titre }}</h5>
            <p class="card-text">{{ $question->contenue }}</p>

            <h6>Réponses :</h6>
            @foreach ($question->reponses as $reponse)
                <div class="alert alert-secondary">
                    <p>{{ $reponse->contenu }} (par {{ $reponse->user->nom }} {{ $reponse->user->prenom }})</p>

                    <!-- Modification et suppression des réponses -->
                    @if ($reponse->id_user == auth()->user()->id_user)
                        <div>
                            <a href="{{ route('professeur.reponse.edit', $reponse->id) }}" class="btn btn-warning">Modifier</a>
                            
                            <form action="{{ route('professeur.reponse.destroy', $reponse->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Formulaire pour ajouter une réponse -->
            <form action="{{ route('professeur.questions.repondre', $question->id_question) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea name="reponse" class="form-control" placeholder="Votre réponse"></textarea>
                    @error('reponse')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Répondre</button>
            </form>
        </div>
    </div>
    @endforeach
@endsection
