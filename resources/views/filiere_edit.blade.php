@extends('layouts.admin')

@section('title', 'Modifier la Filière')

@section('content')
    <div class="container mt-5 bg-warning" >
        <h2 class="mb-4">Modifier la Filière</h2>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('filiere.update', $filiere->id_filiere) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nom_filiere">Nom de la Filière</label>
                <input type="text" class="form-control" id="nom_filiere" name="nom_filiere" value="{{ $filiere->nom_filiere }}" required>
            </div>

            <button type="submit" class="btn btn-warning ">Mettre à jour</button>
        </form>
    </div>
@endsection
