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

    {{-- Barre de recherche et filtre --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une matière...">
        </div>
        <div class="col-md-4">
            <select id="filterFiliere" class="form-control" onchange="location = this.value;">
                <option value="{{ route('matiere.index', ['filiere' => 'all']) }}" 
                        @if ($filiereFilter == 'all') selected @endif>
                    Toutes les Filières
                </option>
                @foreach ($filieres as $filiere)
                    <option value="{{ route('matiere.index', ['filiere' => strtolower($filiere->nom_filiere)]) }}" 
                            @if ($filiereFilter == strtolower($filiere->nom_filiere)) selected @endif>
                        {{ $filiere->nom_filiere }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('matiere.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer
            </a>
        </div>
    </div>

    {{-- Tableau des matières --}}
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nom de la Matière</th>
                <th>Filière Associée</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="matiereTable">
            @forelse ($matieres as $matiere)
                <tr>
                    <td>{{ $matiere->Nom }}</td>
                    <td>{{ $matiere->filiere->nom_filiere }}</td>
                    <td>{{ $matiere->description }}</td>
                    <td class="text-right">
                        <a href="{{ route('matiere.edit', $matiere->id_Matiere) }}" class="btn btn-info btn-sm">
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
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune matière trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
                {{ $matieres->links('pagination::bootstrap-4') }}
            </ul>
        </nav>
    </div>
</div>

{{-- Script de recherche en temps réel --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            
            $('#matiereTable tr').each(function() {
                var matiereName = $(this).find('td:first').text().toLowerCase(); // Récupère la 1ère colonne (Nom de la Matière)

                if (matiereName.includes(searchTerm)) {
                    $(this).show(); // Affiche la ligne si elle correspond
                } else {
                    $(this).hide(); // Cache la ligne sinon
                }
            });
        });
    });
</script>

@endsection
