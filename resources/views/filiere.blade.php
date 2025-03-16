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
            <div class="col-md-10">
                <form method="GET" action="{{ route('filiere.index') }}">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher une filière..." value="{{ request('search') }}">
                </form>
            </div>
            <div class="col-md-2 text-right">
                <a href="{{ route('filiere.form') }}" class="btn" style="color: #17a2b8; font-size: 16px; padding: 8px 20px; text-decoration: none;">
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
            <tbody>
                @foreach ($filieres as $filiere)
                    <tr>
                        <td>{{ $filiere->nom_filiere }}</td>
                        <td class="text-right" style="padding-right: 20px;">
                            {{-- Modifier --}}
                            <a href="{{ route('filiere.edit', $filiere->id_filiere) }}" class="btn" style="color: #17a2b8; font-size: 16px; padding: 8px 15px; text-decoration: none;">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Supprimer --}}
                            <form action="{{ route('filiere.destroy', $filiere->id_filiere)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')" style="color: #dc3545; font-size: 16px; padding: 8px 15px; text-decoration: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $filieres->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection











