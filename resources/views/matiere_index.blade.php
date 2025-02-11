@extends('layouts.admin')

@section('title', 'Liste des Matières')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Liste des Matières</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- barre de recherche et filtre --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une matière...">
            </div>
            <div class="col-md-4">
                <select id="filterFiliere" class="form-control">
                    <option value="">Toutes les Filières</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ strtolower($filiere->nom_filiere) }}">{{ $filiere->nom_filiere }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('matiere.form') }}" class="btn" style="background-color: #2a2aba; color: white;">
                    <i class="fas fa-plus"></i> Créer
                </a>
            </div>
        </div>

        {{-- tableau ds matieres --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 30%;">Nom de la Matière</th>
                    <th style="width: 30%;">Filière Associée</th>
                    <th style="width: 25%;">Description</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody id="matiereTable">
                @foreach ($matieres as $matiere)
                    <tr>
                        <td>{{ $matiere->Nom }}</td>
                        <td>{{ $matiere->filiere->nom_filiere }}</td>
                        <td>{{ $matiere->description }}</td>
                        <td class="text-right" style="padding-right: 20px;">
                            <a href="{{ route('matiere.edit', $matiere->id_Matiere) }}" class="btn btn-info btn-sm" style="margin-right: 5px;">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <form action="{{ route('matiere.destroy', $matiere->id_Matiere) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- script de recherche et filtre --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                filterTable();
            });

            $('#filterFiliere').on('change', function() {
                filterTable();
            });

            function filterTable() {
                var searchTerm = $('#searchInput').val().toLowerCase();
                var selectedFiliere = $('#filterFiliere').val().toLowerCase();

                $('#matiereTable tr').each(function() {
                    var lineText = $(this).text().toLowerCase();
                    var filiereText = $(this).find('td:nth-child(2)').text().toLowerCase();

                    if (lineText.includes(searchTerm) && (selectedFiliere === "" || filiereText === selectedFiliere)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    </script>
@endsection




