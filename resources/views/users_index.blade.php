@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Liste des Utilisateurs</h2>
    
    {{-- affichage du message de succès --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Formulaire de recherche et filtre --}}
    <form method="GET" action="{{ route('user.index') }}" class="mb-3" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <div class="d-flex justify-content-between align-items-center" style="gap: 15px;">
            {{-- Recherche --}}
            <div class="d-flex">
                <input type="text" name="search" id="searchInput" class="form-control me-3" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}" style="border-radius: 5px; border: 1px solid #ced4da; padding: 8px 15px; font-size: 16px; width: 280px;">
            </div>

            {{-- Filtre par rôle --}}
            <select id="roleFilter" name="role" class="form-control me-3" onchange="this.form.submit()" style="border-radius: 5px; border: 1px solid #ced4da; padding: 8px 15px; font-size: 16px; width: 220px;">
                <option value="">Tous les Rôles</option>
                <option value="professeur" {{ request('role') == 'professeur' ? 'selected' : '' }}>Professeurs</option>
                <option value="administrateur" {{ request('role') == 'administrateur' ? 'selected' : '' }}>Administrateurs</option>
                <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiants</option>
            </select>

            {{-- Bouton Créer --}}
            <a href="{{ route('user.form') }}" class="btn btn-link" style="color: #007bff; font-size: 16px; padding: 8px 20px; text-decoration: none; border: none; transition: color 0.3s ease;">
                <i class="fas fa-plus"></i> Créer
            </a>
        </div>
    </form>

    {{-- Tableau des utilisateurs --}}
    <table id="userTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->nom }}</td>
                    <td>{{ $user->prenom }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td class="text-right">
                        {{-- Bouton Modifier --}}
                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-link" style="color: #17a2b8; font-size: 16px; padding: 8px 15px; text-decoration: none; border: none; transition: color 0.3s ease;">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Bouton Supprimer --}}
                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link" style="color: #dc3545; font-size: 16px; padding: 8px 15px; text-decoration: none; border: none; transition: color 0.3s ease;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun utilisateur trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
                {{ $users->links('pagination::bootstrap-4') }}
            </ul>
        </nav>
    </div>
</div>

{{-- Script de recherche --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('#userTable tbody tr').each(function() {
                var lineText = $(this).text().toLowerCase();
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


