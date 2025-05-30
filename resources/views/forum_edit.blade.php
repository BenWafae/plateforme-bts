@extends('layouts.navbar')

@section('title', 'Modifier la question')

@section('content')
<style>
    body {
        background-color: #f4f6fc;
    }

    .btn-violet {
        background-color: #7879E3;
        color: white;
        border: none;
    }

    .btn-violet:hover {
        background-color: #5f60c7;
    }

    .text-violet {
        color: #7879E3;
    }

    .border-violet {
        border-color: #7879E3 !important;
    }
</style>

<div class="container py-5">
    <h3 class="mb-4 fw-bold text-violet">✏️ Modifier votre question</h3>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.update', $question->id_question) }}" method="POST" class="bg-white p-4 rounded-4 shadow-sm border border-violet">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titre" class="form-label fw-semibold text-violet">Titre de la question</label>
            <input type="text" name="titre" id="titre" class="form-control rounded-3 border-violet" value="{{ old('titre', $question->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="contenue" class="form-label fw-semibold text-violet">Contenu</label>
            <textarea name="contenue" id="contenue" class="form-control rounded-3 border-violet" rows="5" required>{{ old('contenue', $question->contenue) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="id_Matiere" class="form-label fw-semibold text-violet">Matière</label>
            <select name="id_Matiere" id="id_Matiere" class="form-select rounded-3 border-violet" required>
                <option value="">-- Sélectionner une matière --</option>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id_Matiere }}" {{ $question->id_Matiere == $matiere->id_Matiere ? 'selected' : '' }}>
                        {{ $matiere->Nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('forumetudiants.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left"></i> Annuler
            </a>
            <button type="submit" class="btn btn-violet rounded-pill">
                <i class="bi bi-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
