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

        /* Masquer le texte de comptage de pagination Laravel */
        .pagination-info,
        nav[aria-label*="Pagination"] p,
        nav p,
        .pagination-wrapper p {
            display: none !important;
        }

        /* Styles pour la pagination personnalisée avec couleurs violettes */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin: 0;
            padding: 0;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            padding: 10px 15px;
            margin: 0 2px;
            border: 2px solid #5E60CE;
            border-radius: 8px;
            color: #5E60CE;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 45px;
            background: white;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
            border-color: #5E60CE;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(94, 96, 206, 0.4);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
            border-color: #5E60CE;
            box-shadow: 0 4px 12px rgba(94, 96, 206, 0.5);
            transform: translateY(-1px);
        }

        .pagination .page-item.disabled .page-link {
            color: #D1D5DB;
            border-color: #E5E7EB;
            background-color: #F9FAFB;
            cursor: not-allowed;
        }

        .pagination .page-item.disabled .page-link:hover {
            background-color: #F9FAFB;
            color: #D1D5DB;
            transform: none;
            box-shadow: none;
        }

        /* Style pour les flèches de navigation avec couleurs violettes */
        .pagination .page-link[aria-label*="Previous"],
        .pagination .page-link[aria-label*="Next"] {
            font-weight: bold;
            background: linear-gradient(135deg, #E0E7FF, #C7D2FE);
            color: #5E60CE;
            border-color: #5E60CE;
        }

        .pagination .page-link[aria-label*="Previous"]:hover,
        .pagination .page-link[aria-label*="Next"]:hover {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
        }

        /* Styles pour le scroll horizontal sur mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
        }

        /* Personnalisation de la scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4F50AD, #6A6BD4);
        }

        /* Styles pour maintenir la largeur minimale du tableau */
        .table-responsive table {
            min-width: 700px; /* Largeur minimale pour éviter la compression */
        }

        /* Indication visuelle pour le scroll sur mobile */
        @media (max-width: 768px) {
            .scroll-indicator {
                display: block;
                text-align: center;
                color: #5E60CE;
                font-size: 12px;
                margin-bottom: 8px;
                animation: pulse 2s infinite;
            }
            
            .scroll-indicator i {
                margin: 0 4px;
            }
        }

        @media (min-width: 769px) {
            .scroll-indicator {
                display: none;
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        /* Amélioration de l'affichage des colonnes sur mobile */
        @media (max-width: 768px) {
            .table-responsive table th,
            .table-responsive table td {
                padding: 12px 8px;
                white-space: nowrap;
            }
            
            .table-responsive table th:first-child,
            .table-responsive table td:first-child {
                padding-left: 16px;
                position: sticky;
                left: 0;
                background-color: white;
                z-index: 10;
                box-shadow: 2px 0 4px rgba(0,0,0,0.1);
            }
            
            .table-responsive table th:first-child {
                background-color: rgba(94, 96, 206, 0.05);
            }
            
            .table-responsive table tbody tr:hover td:first-child {
                background-color: rgba(94, 96, 206, 0.05);
            }
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
                               value="{{ $searchTerm ?? '' }}">
                    </div>

                    {{-- Filtre par rôle --}}
                    <div>
                        <label for="roleFilter" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter text-violet-custom mr-1"></i>
                            Filtrer par rôle
                        </label>
                        <select id="roleFilter" 
                                name="role" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-custom focus:border-violet-custom transition-colors">
                            <option value="">Tous les Rôles</option>
                            <option value="professeur" {{ request('role') == 'professeur' ? 'selected' : '' }}>Professeurs</option>
                            <option value="administrateur" {{ request('role') == 'administrateur' ? 'selected' : '' }}>Administrateurs</option>
                            <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiants</option>
                        </select>
                    </div>

                    {{-- Bouton Créer seulement --}}
                    <div class="flex justify-end">
                        <a href="{{ route('user.form') }}" class="btn-violet">
                            <i class="fas fa-plus"></i>
                            Créer un utilisateur
                        </a>
                    </div>
                </div>

                {{-- Affichage des filtres actifs --}}
                @if($searchTerm || $roleFilter)
                <div class="mt-4 p-3 bg-violet-50 rounded-lg border border-violet-custom">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-violet-custom">
                                <i class="fas fa-filter mr-1"></i>
                                Filtres actifs:
                            </span>
                            @if($searchTerm)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-violet-custom text-white">
                                    Recherche: "{{ $searchTerm }}"
                                </span>
                            @endif
                            @if($roleFilter)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-violet-custom text-white">
                                    Rôle: {{ ucfirst($roleFilter) }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('user.index') }}" class="text-sm text-violet-custom hover:text-violet-700 transition-colors">
                            <i class="fas fa-times mr-1"></i>
                            Effacer les filtres
                        </a>
                    </div>
                </div>
                @endif
            </form>
        </div>

        {{-- Tableau des utilisateurs --}}
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-violet-custom">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-table text-violet-custom mr-2"></i>
                    Tableau des utilisateurs
                </h3>
            </div>

            {{-- Indicateur de scroll pour mobile --}}
            <div class="scroll-indicator">
                <i class="fas fa-arrow-left"></i>
                Faites défiler horizontalement pour voir plus
                <i class="fas fa-arrow-right"></i>
            </div>

            {{-- Container avec scroll horizontal --}}
            <div class="table-responsive">
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
                                <td class="py-3 px-4 border-b border-gray-200">{{ $user->email }}</td>
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
                                    <p class="text-lg">
                                        @if($searchTerm || $roleFilter)
                                            Aucun utilisateur trouvé avec les critères de recherche.
                                        @else
                                            Aucun utilisateur trouvé.
                                        @endif
                                    </p>
                                    @if($searchTerm || $roleFilter)
                                        <a href="{{ route('user.index') }}" class="text-violet-custom hover:text-violet-700 transition-colors mt-2 inline-block">
                                            <i class="fas fa-arrow-left mr-1"></i>
                                            Voir tous les utilisateurs
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="mt-8 flex justify-center">
                <nav aria-label="Pagination Navigation">
                    {{ $users->appends(request()->query())->links() }}
                </nav>
            </div>
            @endif
        </div>
    </div>

    {{-- Script pour améliorer l'UX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Soumission automatique du formulaire lors du changement de filtre de rôle
            $('#roleFilter').on('change', function() {
                $(this).closest('form').submit();
            });

            // Soumission automatique du formulaire lors de la saisie dans le champ de recherche (avec délai)
            let searchTimeout;
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    $(this).closest('form').submit();
                }, 500); // Délai de 500ms après la dernière saisie
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

            // Mise en évidence des résultats de recherche - CORRIGÉ
            @if($searchTerm)
            var searchTerm = "{{ $searchTerm }}";
            if (searchTerm) {
                $('#userTable tbody tr').each(function() {
                    // Ne cibler que les 3 premières colonnes (nom, prénom, email) - exclure les actions
                    $(this).find('td:lt(3)').each(function() {
                        var text = $(this).text(); // Utiliser .text() au lieu de .html()
                        var highlightedText = text.replace(
                            new RegExp('(' + searchTerm + ')', 'gi'),
                            '<mark style="background-color: #FEF3C7; padding: 2px 4px; border-radius: 3px;">$1</mark>'
                        );
                        // Seulement remplacer si le texte a changé (contient le terme recherché)
                        if (highlightedText !== text) {
                            $(this).html(highlightedText);
                        }
                    });
                });
            }
            @endif

            // Animation au chargement
            $('tbody tr').each(function(index) {
                $(this).css('opacity', '0').delay(index * 50).animate({
                    opacity: 1
                }, 300);
            });

            // Masquer l'indicateur de scroll après interaction
            $('.table-responsive').on('scroll', function() {
                $('.scroll-indicator').fadeOut(300);
            });

            // Afficher/masquer l'indicateur selon la largeur de l'écran
            function checkScrollIndicator() {
                if ($(window).width() <= 768) {
                    if ($('.table-responsive')[0].scrollWidth > $('.table-responsive')[0].clientWidth) {
                        $('.scroll-indicator').show();
                    } else {
                        $('.scroll-indicator').hide();
                    }
                }
            }

            // Vérifier au chargement et au redimensionnement
            checkScrollIndicator();
            $(window).on('resize', checkScrollIndicator);
        });
    </script>

@endsection