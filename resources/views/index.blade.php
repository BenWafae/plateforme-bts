@extends('layouts.admin')

@section('title', 'Gestion des Filières')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Liste des Filières</h2>
        
        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Champ de recherche -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une filière...">
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('filiere.form') }}" class="btn" style="background-color: #2a2aba; color: white;">
                    <i class="fas fa-plus"></i> Créer
                </a>
            </div>
        </div>

        {{-- Tableau des filières --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50%;">Nom de la Filière</th>
                    <th style="width: 30%;">Actions</th>
                </tr>
            </thead>
            <tbody id="filiereTable">
                @foreach ($filieres as $filiere)
                    <tr>
                        <td>{{ $filiere->nom_filiere }}</td>
                        <td class="text-right" style="padding-right: 20px;">
                            {{-- Modifier --}}
                            <a href="{{ route('filiere.edit', $filiere->id_filiere) }}" class="btn btn-info btn-sm" style="margin-right: 5px;">
                                <i class="fas fa-edit"></i> 
                            </a>

                            {{-- Supprimer --}}
                            <form action="{{ route('filiere.destroy', $filiere->id_filiere)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')" style="margin-right: 5px;">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Script de recherche --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Lorsque l'utilisateur tape dans le champ de recherche
            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase(); // Récupère le texte de recherche et le met en minuscule

                // Filtrer les lignes du tableau
                $('#filiereTable tr').each(function() {
                    var lineText = $(this).text().toLowerCase(); // Récupère le texte de chaque ligne et le met en minuscule

                    // Si le texte de la ligne contient le terme de recherche, l'afficher, sinon le cacher
                    if (lineText.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endsection








