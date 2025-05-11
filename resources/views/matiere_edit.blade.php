@extends('layouts.admin')

@section('title', 'Modifier la Matière')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Modifier la Matière</h2>

        <form action="{{ route('matiere.update', $matiere->id_Matiere) }}" method="POST">
            @csrf
            @method('PUT') 

            <div class="form-group">
                <label for="Nom">Nom de la Matière</label>
                <input type="text" class="form-control" id="Nom" name="Nom" value="{{ old('Nom', $matiere->Nom) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $matiere->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="id_filiere">Filière Associée</label>
                <select class="form-control" id="id_filiere" name="id_filiere" required>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id_filiere }}" {{ $matiere->id_filiere == $filiere->id_filiere ? 'selected' : '' }}>
                            {{ $filiere->nom_filiere }}
                        </option>
                    @endforeach
                </select>
            </div>
             <!-- Ajouter un champ pour sélectionner le professeur -->
            <div class="form-group">
                <label for="id_user">Professeur Associé</label>
                <select class="form-control" id="id_user" name="id_user" required>
                    <option value="" disabled selected>Sélectionnez un professeur</option>
                    @foreach($professeurs as $prof)
                        <option value="{{ $prof->id }}" {{ $matiere->id_user == $prof->id ? 'selected' : '' }}>
                            {{ $prof->nom }} {{ $prof->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à Jour</button>
        </form>
    </div>
@endsection
