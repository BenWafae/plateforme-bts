@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="question-card mb-4 bg-light p-4 border rounded shadow-sm">
        <div class="question-header mb-3">
            <h2 class="text-primary">{{ $question->titre }}</h2>
            <p><strong>Posée par :</strong> {{ $question->user->nom }} {{ $question->user->prenom }}</p>
            <p><strong>Matière : </strong>{{ $question->matiere->Nom }}</p>
            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y H:i') }}</p>
        </div>

        <div class="question-content">
            <p class="lead">{{ $question->contenue }}</p>
        </div>
    </div>

    <hr class="my-4">

    <h3 class="mt-4">Réponses</h3>

    <div class="mt-3">
        @if($question->reponses->isEmpty())
            <p class="text-muted">Personne n'a encore répondu à cette question.</p>
        @else
            @foreach($question->reponses as $reponse)
                <div class="border p-3 rounded mb-3 shadow-sm bg-white">
                    <div class="d-flex justify-content-between mb-2">
                        <p class="mb-0"><strong>{{ $reponse->user->nom }} {{ $reponse->user->prenom }}</strong></p>
                        <p class="mb-0 text-muted">{{ \Carbon\Carbon::parse($reponse->date_pub)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="response-content">
                        <p>{{ $reponse->contenu }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@section('styles')
    <style>
        .question-card {
            background-color: #f0f8ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question-header {
            margin-bottom: 15px;
        }

        .question-header h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
            color: #007bff;
        }

        .question-content {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-top: 10px;
            font-style: italic;
            color: #333;
        }

        .response-card {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .response-content {
            font-size: 1.1rem;
            line-height: 1.5;
            margin-top: 10px;
        }

        .text-muted {
            font-size: 0.95rem;
            color: #6c757d;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 30px;
            color: #343a40;
        }

        .container {
            max-width: 900px;
        }

        hr {
            border-top: 2px solid #007bff;
        }
    </style>
@endsection
@endsection



