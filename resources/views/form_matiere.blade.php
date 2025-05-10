@extends('layouts.admin')

@section('content')
    <h1 class="text-center mb-4">Ajouter une matiere</h1>

    
    <style>
        /* Style pour le texte des options dans le select */
        select.form-select {
            color: #333;  
            background-color: #ffffff;  
        }

        /* Style pour les labels */
        .form-label {
            font-weight: bold;
            color: #333; 
        }

       
        .form-control {
            border-radius: 0.375rem; 
            border: 1px solid #ccc;   
            padding: 10px;
            font-size: 1rem;
        }

        /* Style pour les erreurs */
        .text-danger {
            font-size: 0.875rem;
            color: red;
        }

        /* Style pour le bouton */
        button[type="submit"] {
            font-size: 1.1rem;
            padding: 10px 20px;
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Ajouter un espacement pour les champs */
        .mb-3 {
            margin-bottom: 1.5rem;
        }

        /* Style pour la page entière */
        .content {
            padding: 20px;
        }
    </style>

    <form action="{{ route('matiere.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="Nom" class="form-label">Nom de la matière</label>
            <input type="text" id="Nom" name="Nom" value="{{ old('Nom') }}" class="form-control" required>
            {{-- on a utiliser old pourque apres l'enregistrement la valeur entre dans chaque champs reste apparut --}}
            @error('Nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="id_filiere" class="form-label">Filière</label>
            {{-- on va utiliser select pour afficher une liste deroulant --}}
            <select id="id_filiere" name="id_filiere" class="form-select" required>
                <option value="" disabled selected>Sélectionnez une filière</option>
                @foreach($filieres as $filiere)
                <option value="{{ $filiere->id_filiere }}" {{ old('id_filiere') == $filiere->id_filiere ? 'selected' : '' }}>
                    {{-- option est une option par defaut indique au users de selectionner une filiere --}}
                    {{ $filiere->nom_filiere }}
                </option>
            @endforeach
            </select>
            @error('id_filiere')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- prof --}}
        <div class="mb-3">
    <label for="id_user" class="form-label">Professeur</label>
    <select id="id_user" name="id_user" class="form-select" required>
        <option value="" disabled selected>Sélectionnez un professeur</option>
        @foreach($professeurs as $prof)
        <option value="{{ $prof->id_user }}" {{ old('id_user') == $prof->id_user ? 'selected' : '' }}>
    {{ $prof->nom }} {{ $prof->prenom }}
</option>
 @endforeach
    </select>
    @error('id_user')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

        <button type="submit" class="btn btn-primary w-100 mt-4">Ajouter la matière</button>
    </form>

    <div class="mt-4">
        <a href="{{ route('filiere.index') }}" class="btn btn-secondary w-100">Retour aux filières</a>
    </div>
@endsection




