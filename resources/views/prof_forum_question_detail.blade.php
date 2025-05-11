@extends('layouts.professeur')

@section('content')
<div class="container">
    <h2>Détail de la question</h2>
    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Posée par : </strong>{{ $question->user->prenom }} {{ $question->user->nom }}</p>
            <h5 class="card-title">{{ $question->titre }}</h5>
            <p><strong>Matière : </strong>{{ $question->matiere->Nom }}</p>
            <p class="card-text">{{ $question->contenue }}</p>

            <h6 class="mt-4">Réponses :</h6>
            <div class="mt-3">
                @if($question->reponses->isEmpty())
                    <p class="text-muted">Aucune réponse pour le moment.</p>
                @else
                    @foreach ($question->reponses as $reponse)
                        <div class="mb-3">
                            <p>{{ $reponse->contenu }} <span class="text-muted">(par {{ $reponse->user->prenom }} {{ $reponse->user->nom }})</span></p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
