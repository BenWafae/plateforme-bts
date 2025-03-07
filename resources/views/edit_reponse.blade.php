{{-- resources/views/professeur/reponse/edit.blade.php --}}
@extends('layouts.professeur')

@section('content')
<div class="container">
    <h2>Modifier la Réponse</h2>

    {{-- Affichage des messages d'erreur ou de succès --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulaire d'édition de la réponse --}}
    <form action="{{ route('professeur.reponse.update', $reponse->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="reponse">Réponse :</label>
            <textarea class="form-control" name="reponse" id="reponse" rows="4">{{ old('reponse', $reponse->contenu) }}</textarea>
            @error('reponse')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour la réponse</button>
    </form>

    <a href="{{ route('professeur.questions.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
