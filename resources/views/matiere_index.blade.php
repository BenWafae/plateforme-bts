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
        {{-- Formulaire de recherche --}}
        <div class="col-md-6">
            <form action="{{ route('matiere.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Rechercher une matière..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Filtre par filière --}}
        <div class="col-md-4">
            <select id="filterFiliere" class="form-control" onchange="applyFilter()">
                <option value="{{ route('matiere.index', ['filiere' => 'all', 'search' => request('search')]) }}" 
                        @if ($filiereFilter == 'all') selected @endif>
                    Toutes les Filières
                </option>
                @foreach ($filieres as $filiere)
                    <option value="{{ route('matiere.index', ['filiere' => strtolower($filiere->nom_filiere), 'search' => request('search')]) }}" 
                            @if ($filiereFilter == strtolower($filiere->nom_filiere)) selected @endif>
                        {{ $filiere->nom_filiere }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Bouton de création --}}
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
        <tbody>
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
        {{ $matieres->links('pagination::bootstrap-4') }}
    </div>
</div>

{{-- Script pour appliquer le filtre --}}
<script>
    function applyFilter() {
        let filterFiliere = document.getElementById('filterFiliere').value;
        window.location.href = filterFiliere;
    }
</script>

@endsection

