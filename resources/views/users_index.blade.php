@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Liste des Utilisateurs</h2>
    
    {{-- affichage du message de succès --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- Conteneur pour aligner les éléments horizontalement --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Barre de recherche à gauche --}}
        <div class="w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un utilisateur par nom...">
        </div>

        {{-- Filtrer par rôle au milieu --}}
        <div>
              <!-- Filtre par rôle -->
    <form method="GET" action="{{ route('user.index') }}" class="mb-3">
        <label for="roleFilter">Filtrer par rôle :</label>

        <select id="roleFilter" name="role" class="form-control w-75 d-inline-block" onchange="this.form.submit()" placeholder="Filtrer par role">
            <option value="">Tous les Rôles</option>
            <option value="professeur" {{ request('role') == 'professeur' ? 'selected' : '' }}>Professeurs</option>
            <option value="administrateur" {{ request('role') == 'administrateur' ? 'selected' : '' }}>Administrateurs</option>
            <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiants</option>
        </select>
    </form>

        </div>

        {{-- Bouton Créer à droite --}}
        <div>
            <a href="{{ route('user.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer
            </a>
        </div>
    </div>

    {{-- Tableau des utilisateurs --}}
    <table id="userTable" class="table table-bordered table-hover mt-3">
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
                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
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

