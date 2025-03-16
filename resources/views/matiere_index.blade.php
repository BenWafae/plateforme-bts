@extends('layouts.admin')

@section('title', 'Liste des Matières')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des Matières</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Formulaire de recherche et filtre --}}
    <form method="GET" action="{{ route('matiere.index') }}" class="mb-3" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <div class="d-flex justify-content-between align-items-center" style="gap: 15px;">
            {{-- Recherche --}}
            <div class="d-flex">
                <input type="text" name="search" id="searchInput" class="form-control me-3" placeholder="Rechercher une matière..." value="{{ request('search') }}" style="border-radius: 5px; border: 1px solid #ced4da; padding: 8px 15px; font-size: 16px; width: 280px;">
            </div>

            {{-- Filtre par Filière --}}
            <select id="filterFiliere" name="filiere" class="form-control me-3" onchange="this.form.submit()" style="border-radius: 5px; border: 1px solid #ced4da; padding: 8px 15px; font-size: 16px; width: 220px;">
                <option value="all" @if ($filiereFilter == 'all') selected @endif>Toutes les Filières</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ strtolower($filiere->nom_filiere) }}" @if ($filiereFilter == strtolower($filiere->nom_filiere)) selected @endif>
                        {{ $filiere->nom_filiere }}
                    </option>
                @endforeach
            </select>

            {{-- Bouton Créer --}}
            <a href="{{ route('matiere.form') }}" class="btn btn-link" style="color: #007bff; font-size: 16px; padding: 8px 20px; text-decoration: none; border: none; transition: color 0.3s ease;">
                <i class="fas fa-plus"></i> Créer
            </a>
        </div>
    </form>

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
                        {{-- Bouton Modifier --}}
                        <a href="{{ route('matiere.edit', $matiere->id_Matiere) }}" class="btn btn-link" style="color: #17a2b8; font-size: 16px; padding: 8px 15px; text-decoration: none; border: none; transition: color 0.3s ease;">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Bouton Supprimer --}}
                        <form action="{{ route('matiere.destroy', $matiere->id_Matiere) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link" style="color: #dc3545; font-size: 16px; padding: 8px 15px; text-decoration: none; border: none; transition: color 0.3s ease;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')">
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

@endsection




