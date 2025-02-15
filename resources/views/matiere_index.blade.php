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
            <select id="filterFiliere" class="form-control">
                <option value="">Toutes les Filières</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ strtolower($filiere->nom_filiere) }}">{{ $filiere->nom_filiere }}</option>
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
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                {{-- Pagination simple et bien structurée --}}
                @if ($matieres->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Précédent</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $matieres->previousPageUrl() }}">Précédent</a></li>
                @endif

                @foreach ($matieres->getUrlRange(1, $matieres->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $matieres->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($matieres->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $matieres->nextPageUrl() }}">Suivant</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Suivant</span></li>
                @endif
            </ul>
        </nav>
    </div>
</div>

{{-- Script pour la recherche et le filtre --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
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

{{-- Styles personnalisés pour la pagination --}}
<style>
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    .pagination .page-link {
        color: #007bff;
    }
    .pagination .page-link:hover {
        background-color: #e9ecef;
        color: #0056b3;
    }
</style>
@endsection
