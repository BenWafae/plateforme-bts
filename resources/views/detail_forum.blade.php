@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="question-card mb-4 bg-light p-4 border rounded shadow-sm">
        <!-- Question Title -->
        <div class="question-header mb-3">
            <h2 class="text-primary">{{ $question->titre }}</h2>
            <p><strong>Posée par :</strong> {{ $question->user->nom }} {{ $question->user->prenom }}</p>
            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Question Content -->
        <div class="question-content">
            <p class="lead">{{ $question->contenue }}</p>
        </div>
    </div>

    <hr class="my-4">

    <h3 class="mt-4">Réponses</h3>
    @foreach($question->reponses as $reponse)
    <div class="border p-3 rounded mb-3 shadow-sm bg-white">
        <div class="d-flex justify-content-between mb-2">
            <p class="mb-0"><strong>{{ $reponse->user->nom }} {{ $reponse->user->prenom }}</strong></p>
            <p class="mb-0 text-muted">{{ \Carbon\Carbon::parse($reponse->date_pub)->format('d/m/Y H:i') }}</p>
        </div>
        
        <!-- Response Content -->
        <div class="response-content">
            <p>{{ $reponse->contenu }}</p>
        </div>
    </div>
    @endforeach
</div>

@section('styles')
    <style>
        .question-card {
            background-color: #f0f8ff; /* Light blue background */
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
            color: #007bff; /* Primary blue color for question title */
        }

        .question-content {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-top: 10px;
            font-style: italic;
            color: #333; /* Slightly darker color for content */
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
            font-size: 0.9rem;
            color: #777;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 30px;
            color: #343a40; /* Dark grey color for headings */
        }

        .container {
            max-width: 900px;
        }

        /* Separator for question and answers */
        hr {
            border-top: 2px solid #007bff; /* Blue color for separator line */
        }

    </style>
@endsection
@endsection



