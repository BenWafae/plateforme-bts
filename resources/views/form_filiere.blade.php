@extends('layouts.admin')

@section('title', 'Formulaire Filière')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Créer une nouvelle Filière</h2>
        
        <!-- Affichage du message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de création de filière -->
        <form action="{{ route('filiere.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nom_filiere" class="font-weight-bold">Nom de la Filière</label>
                <input type="text" id="nom_filiere" name="nom_filiere" class="form-control" placeholder="nom filiere" required>
                  <!-- Afficher l'erreur -->
    @error('nom_filiere')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Ajouter la Filière</button>
            </div>
        </form>
    </div>
@endsection











    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>
