@extends('layouts.navbar') <!-- Étendre le layout principal avec la sidebar -->

@section('title', 'Poser une question') <!-- Titre de la page -->

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Poser une question</h2>

        <!-- Affichage des messages de succès -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire pour poser une question -->
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf <!-- Protection CSRF -->

            <!-- Titre de la question -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre de la question :</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>

            <!-- Contenu de la question -->
            <div class="mb-3">
                <label for="contenue" class="form-label">Contenu :</label>
                <textarea class="form-control" id="contenue" name="contenue" rows="4" required></textarea>
            </div>

            <!-- Sélectionner la matière -->
            <div class="mb-3">
                <label for="id_Matiere" class="form-label">Sélectionner la matière :</label>
                <select class="form-control" id="id_Matiere" name="id_Matiere" required>
                    <option value="">-- Choisissez une matière --</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id_Matiere }}">{{ $matiere->Nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

        <!-- Lien pour revenir à la page du forum -->
        <div class="mt-4">
            <a href="{{ route('forumetudiants.index') }}" class="btn btn-secondary">Retour au Forum</a>
        </div>
    </div>
@endsection
