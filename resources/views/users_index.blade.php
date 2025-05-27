@extends('layouts.admin')

@section('content')
    <style>
        /* Configuration des couleurs personnalisées */
        .bg-violet-custom {
            background-color: #5E60CE;
        }
        .text-violet-custom {
            color: #5E60CE;
        }
        .border-violet-custom {
            border-color: #5E60CE;
        }
        .bg-violet-50 {
            background-color: rgba(94, 96, 206, 0.05);
        }
        .hover\:text-violet-700:hover {
            color: #4F50AD;
        }
        .hover\:bg-violet-600:hover {
            background-color: #4F50AD;
        }
        .from-violet-custom {
            --tw-gradient-from: #5E60CE;
            --tw-gradient-to: rgba(94, 96, 206, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-violet-custom {
            --tw-gradient-to: #5E60CE;
        }
        
        /* Styles pour les boutons d'action */
        .btn-violet {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-violet:hover {
            background: linear-gradient(135deg, #4F50AD, #6A6BD4);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(94, 96, 206, 0.3);
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #7879E3, #9B9EF0);
        }
        .btn-edit:hover {
            background: linear-gradient(135deg, #6A6BD4, #8A8DE8);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #9B9EF0, #B8BBFF);
        }
        .btn-delete:hover {
            background: linear-gradient(135deg, #8A8DE8, #A5A8F7);
        }
    </style>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Liste des Utilisateurs</h1>

        {{-- Affichage du message de succès --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
        @endif

        {{-- Formulaire de recherche et filtre --}}
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-t-4 border-violet-custom">
            <form method="GET" action="{{ route('user.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    {{-- Recherche --}}
                    <div>
                        <label for="searchInput" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search text-violet-custom mr-1"></i>
                            Rechercher un utilisateur
                        </label>
                        <input type="text" 
                               name="search" 
                               id="searchInput" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-custom focus:border-violet-custom transition-colors" 
                               placeholder="Nom, prénom ou email..." 
                               value="{{ request('search') }}">
                    </div>

                    {{-- Filtre par rôle --}}
                    <div>
                        <label for="roleFilter" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter text-violet-custom mr-1"></i>
                            Filtrer par rôle
                        </label>
                        <select id="roleFilter" 
                                name="role" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-custom focus:border-violet-custom transition-colors" 
                                onchange="this.form.submit()">
                            <option value="">Tous les Rôles</option>
                            <option value="professeur" {{ request('role') == 'professeur' ? 'selected' : '' }}>Professeurs</option>
                            <option value="administrateur" {{ request('role') == 'administrateur' ? 'selected' : '' }}>Administrateurs</option>
                            <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiants</option>
                        </select>
                    </div>

                    {{-- Bouton Créer --}}
                    <div class="flex justify-end">
                        <a href="{{ route('user.form') }}" class="btn-violet">
                            <i class="fas fa-plus"></i>
                            Créer un utilisateur
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Carte des statistiques rapides --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-violet-custom to-purple-600 text-white p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-users text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm opacity-90">Total Utilisateurs</p>
                        <p class="text-xl font-bold">{{ $users->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-indigo-500 to-violet-custom text-white p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-chalkboard-teacher text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm opacity-90">Professeurs</p>
                        <p class="text-xl font-bold">{{ $users->where('role', 'professeur')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-violet-custom text-white p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-user-graduate text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm opacity-90">Étudiants</p>
                        <p class="text-xl font-bold">{{ $users->where('role', 'etudiant')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau des utilisateurs --}}
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-table text-violet-custom mr-2"></i>
                Tableau des utilisateurs
            </h3>

            <div class="overflow-x-auto">
                <table id="userTable" class="w-full text-left table-auto">
                    <thead class="bg-violet-50">
                        <tr>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">
                                <i class="fas fa-user mr-1"></i>
                                Nom
                            </th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">
                                <i class="fas fa-user mr-1"></i>
                                Prénom
                            </th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">
                                <i class="fas fa-envelope mr-1"></i>
                                Email
                            </th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">
                                <i class="fas fa-user-tag mr-1"></i>
                                Rôle
                            </th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold text-center">
                                <i class="fas fa-cogs mr-1"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="hover:bg-violet-50 transition-colors duration-150">
                                <td class="py-3 px-4 border-b border-gray-200 font-medium">{{ $user->nom }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $user->prenom }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    <a href="mailto:{{ $user->email }}" class="text-violet-custom hover:text-violet-700 transition-colors">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        @if($user->role == 'administrateur') bg-red-100 text-red-800
                                        @elseif($user->role == 'professeur') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        @if($user->role == 'administrateur')
                                            <i class="fas fa-shield-alt mr-1"></i>
                                        @elseif($user->role == 'professeur')
                                            <i class="fas fa-chalkboard-teacher mr-1"></i>
                                        @else
                                            <i class="fas fa-user-graduate mr-1"></i>
                                        @endif
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200 text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Bouton Modifier --}}
                                        <a href="{{ route('user.edit', $user->id_user) }}" 
                                           class="btn-violet btn-edit"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Bouton Supprimer --}}
                                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-violet btn-delete"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                    <i class="fas fa-users text-4xl mb-2 opacity-50"></i>
                                    <p class="text-lg">Aucun utilisateur trouvé.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="mt-6 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif
        </div>
    </div>

    {{-- Script de recherche amélioré --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Recherche en temps réel
            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                var visibleRows = 0;
                
                $('#userTable tbody tr').each(function() {
                    var lineText = $(this).text().toLowerCase();
                    if (lineText.includes(searchTerm)) {
                        $(this).show();
                        visibleRows++;
                    } else {
                        $(this).hide();
                    }
                });
                
                // Afficher un message si aucun résultat
                if (visibleRows === 0 && searchTerm !== '') {
                    if ($('#no-results').length === 0) {
                        $('#userTable tbody').append(
                            '<tr id="no-results"><td colspan="5" class="py-8 px-4 text-center text-gray-500">' +
                            '<i class="fas fa-search text-4xl mb-2 opacity-50"></i>' +
                            '<p class="text-lg">Aucun résultat trouvé pour "' + searchTerm + '"</p></td></tr>'
                        );
                    }
                } else {
                    $('#no-results').remove();
                }
            });

            // Animation des boutons au hover
            $('.btn-violet').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
        });
    </script>

@endsection

