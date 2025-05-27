@extends('layouts.navbar') <!-- Étendre le layout principal avec la sidebar -->

@section('title', 'Poser une question') <!-- Titre de la page -->

@section('content')
<div class="container my-5">
    <div class="bg-white p-5 shadow rounded-4 border-start border-5" style="border-color: #5E60CE;">
        <h2 class="fw-bold mb-4 text-primary">✍️ Poser une question</h2>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de question -->
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="titre" class="form-label fw-semibold">Titre de la question :</label>
                <input type="text" class="form-control rounded-3 shadow-sm" id="titre" name="titre" placeholder="Ex: Comment résoudre cette équation ?" required>
            </div>

            <div class="mb-4">
                <label for="contenue" class="form-label fw-semibold">Contenu :</label>
                <textarea class="form-control rounded-3 shadow-sm" id="contenue" name="contenue" rows="5" placeholder="Décrivez votre question ou problème en détail..." required></textarea>
            </div>

            <div class="mb-4">
                <label for="id_Matiere" class="form-label fw-semibold">Matière concernée :</label>
                <select class="form-select rounded-3 shadow-sm" id="id_Matiere" name="id_Matiere" required>
                    <option value="">-- Choisissez une matière --</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id_Matiere }}">{{ $matiere->Nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('forumetudiants.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left-circle"></i> Retour au Forum
                </a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-send"></i> Envoyer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
