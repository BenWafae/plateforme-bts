@extends('layouts.admin')

@section('title', 'Liste des Matières')

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
        .hover\:bg-violet-50:hover {
            background-color: rgba(94, 96, 206, 0.05);
        }
        .from-violet-custom {
            --tw-gradient-from: #5E60CE;
            --tw-gradient-to: rgba(94, 96, 206, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-violet-custom {
            --tw-gradient-to: #5E60CE;
        }
        .btn-violet-custom {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-violet-custom:hover {
            background: linear-gradient(135deg, #4F50AD, #6B6DD9);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(94, 96, 206, 0.3);
        }
        .form-control-custom {
            border: 2px solid rgba(94, 96, 206, 0.2);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .form-control-custom:focus {
            border-color: #5E60CE;
            box-shadow: 0 0 0 0.2rem rgba(94, 96, 206, 0.25);
        }
        .table-custom {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table-custom thead {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
        }
        .table-custom thead th {
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }
        .table-custom tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(94, 96, 206, 0.1);
        }
        .table-custom tbody tr:hover {
            background-color: rgba(94, 96, 206, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(94, 96, 206, 0.15);
        }
        .table-custom tbody td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
        }
        .search-filter-container {
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.1), rgba(120, 121, 227, 0.05));
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(94, 96, 206, 0.1);
            border-top: 4px solid #5E60CE;
        }
        .action-btn {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-edit {
            color: #17a2b8;
            background-color: rgba(23, 162, 184, 0.1);
        }
        .btn-edit:hover {
            color: white;
            background-color: #17a2b8;
        }
        .btn-delete {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }
        .btn-delete:hover {
            color: white;
            background-color: #dc3545;
        }
        .alert-success-custom {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-left: 4px solid #28a745;
            color: #155724;
            border-radius: 8px;
        }

        /* Amélioration pour les noms de filières très longs */
        .filiere-select-custom {
            min-width: 100%;
            width: 100%;
            font-size: 0.9rem;
            padding: 8px 12px;
            text-overflow: ellipsis;
        }
        
        .filiere-select-custom option {
            padding: 10px 15px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.5;
            font-size: 0.9rem;
            max-width: 100%;
        }

        /* Styles améliorés pour l'affichage des filières longues dans le tableau */
        .filiere-badge {
            display: inline-block;
            position: relative;
            max-width: 100%;
            padding: 8px 12px;
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.1), rgba(120, 121, 227, 0.05));
            border: 1px solid rgba(94, 96, 206, 0.2);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #5E60CE;
            cursor: help;
            transition: all 0.3s ease;
            line-height: 1.4;
            word-wrap: break-word;
            hyphens: auto;
        }

        .filiere-badge:hover {
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.15), rgba(120, 121, 227, 0.08));
            border-color: rgba(94, 96, 206, 0.4);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(94, 96, 206, 0.2);
        }

        /* Tooltip personnalisé pour les filières */
        .filiere-tooltip {
            position: relative;
        }

        .filiere-tooltip .tooltip-text {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #2d3748;
            color: white;
            text-align: center;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            white-space: nowrap;
            z-index: 1000;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.3;
        }

        .filiere-tooltip .tooltip-text::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 8px solid transparent;
            border-top-color: #2d3748;
        }

        .filiere-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(-5px);
        }

        /* Amélioration de la largeur des colonnes */
        .table-custom th:nth-child(1) { /* Nom de la matière */
            width: 25%;
            min-width: 200px;
        }
        
        .table-custom th:nth-child(2) { /* Filière */
            width: 35%;
            min-width: 250px;
        }
        
        .table-custom th:nth-child(3) { /* Description */
            width: 30%;
            min-width: 200px;
        }
        
        .table-custom th:nth-child(4) { /* Actions */
            width: 10%;
            min-width: 120px;
        }

        /* Amélioration du texte de description */
        .description-cell {
            max-width: 200px;
            word-wrap: break-word;
            line-height: 1.4;
            color: #4a5568;
        }

        /* Bouton compact */
        .btn-compact {
            min-width: 60px;
            padding: 8px 12px !important;
            font-size: 0.875rem;
        }

        /* Responsive design pour les noms longs */
        @media (max-width: 768px) {
            .search-filter-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .filiere-select-custom {
                font-size: 0.85rem;
            }
            
            .btn-compact {
                width: 100%;
                justify-content: center;
            }

            .table-custom th:nth-child(1) { width: 30%; }
            .table-custom th:nth-child(2) { width: 40%; }
            .table-custom th:nth-child(3) { width: 20%; }
            .table-custom th:nth-child(4) { width: 10%; }

            .filiere-badge {
                font-size: 0.8rem;
                padding: 6px 10px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .filiere-select-custom {
                font-size: 0.85rem;
            }
            
            .filiere-badge {
                font-size: 0.83rem;
            }
        }

        @media (min-width: 1280px) {
            .filiere-select-custom {
                font-size: 0.95rem;
            }
            
            .filiere-badge {
                font-size: 0.87rem;
            }
        }
    </style>

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8 flex items-center justify-center">
            <i class="fas fa-book text-violet-custom mr-3"></i>
            Liste des Matières
        </h1>

        @if (session('success'))
            <div class="alert alert-success-custom alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Formulaire de recherche et filtre --}}
        <div class="search-filter-container mb-6">
            <form method="GET" action="{{ route('matiere.index') }}" class="mb-0">
                <div class="search-filter-grid grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                    {{-- Recherche --}}
                    <div class="lg:col-span-3 flex flex-col">
                        <label for="searchInput" class="text-violet-custom font-semibold mb-2 flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher
                        </label>
                        <input type="text" 
                               name="search" 
                               id="searchInput" 
                               class="form-control form-control-custom" 
                               placeholder="Rechercher une matière..." 
                               value="{{ request('search') }}">
                    </div>

                    {{-- Filtre par Filière - Maximum d'espace --}}
                    <div class="lg:col-span-7 flex flex-col">
                        <label for="filterFiliere" class="text-violet-custom font-semibold mb-2 flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            Filière
                        </label>
                        <select id="filterFiliere" 
                                name="filiere" 
                                class="form-control form-control-custom filiere-select-custom" 
                                onchange="this.form.submit()"
                                title="Sélectionner une filière">
                            <option value="all" @if ($filiereFilter == 'all') selected @endif>Toutes les Filières</option>
                            @foreach ($filieres as $filiere)
                                <option value="{{ strtolower($filiere->nom_filiere) }}" 
                                        @if ($filiereFilter == strtolower($filiere->nom_filiere)) selected @endif
                                        title="{{ $filiere->nom_filiere }}">
                                    {{ $filiere->nom_filiere }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bouton Créer - Compact --}}
                    <div class="lg:col-span-2 create-btn-container flex justify-end">
                        <a href="{{ route('matiere.form') }}" 
                           class="btn btn-violet-custom px-3 py-2 rounded-lg font-medium flex items-center w-full lg:w-auto justify-center text-sm"
                           title="Créer une nouvelle matière">
                            <i class="fas fa-plus mr-1"></i>
                            <span class="hidden xl:inline">Créer</span>
                            <span class="xl:hidden">+</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tableau des matières --}}
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-violet-custom">
            <div class="overflow-x-auto">
                <table class="table-custom w-full">
                    <thead>
                        <tr>
                            <th class="text-left">
                                <i class="fas fa-book-open mr-2"></i>
                                Nom de la Matière
                            </th>
                            <th class="text-left">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Filière Associée
                            </th>
                            <th class="text-left">
                                <i class="fas fa-align-left mr-2"></i>
                                Description
                            </th>
                            <th class="text-center">
                                <i class="fas fa-cogs mr-2"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matieres as $matiere)
                            <tr>
                                <td class="font-semibold text-gray-800">{{ $matiere->Nom }}</td>
                                <td>
                                    <div class="filiere-tooltip">
                                        <div class="filiere-badge" title="{{ $matiere->filiere->nom_filiere }}">
                                            {{ $matiere->filiere->nom_filiere }}
                                        </div>
                                        <div class="tooltip-text">
                                            {{ $matiere->filiere->nom_filiere }}
                                        </div>
                                    </div>
                                </td>
                                <td class="description-cell">{{ $matiere->description }}</td>
                                <td class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Bouton Modifier --}}
                                        <a href="{{ route('matiere.edit', $matiere->id_Matiere) }}" 
                                           class="action-btn btn-edit" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Bouton Supprimer --}}
                                        <form action="{{ route('matiere.destroy', $matiere->id_Matiere) }}" 
                                              method="POST" 
                                              style="display:inline;" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-btn btn-delete" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8">
                                    <div class="flex flex-col items-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-4 text-violet-custom opacity-50"></i>
                                        <p class="text-lg">Aucune matière trouvée</p>
                                        <p class="text-sm">Essayez de modifier vos critères de recherche</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($matieres->hasPages())
            <div class="flex justify-center mt-6">
                <div class="bg-white rounded-lg shadow-md p-4 border-t-4 border-violet-custom">
                    {{ $matieres->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Personnalisation de la pagination */
        .pagination .page-link {
            color: #5E60CE;
            border-color: rgba(94, 96, 206, 0.2);
            transition: all 0.2s ease;
        }
        .pagination .page-link:hover {
            color: white;
            background-color: #5E60CE;
            border-color: #5E60CE;
        }
        .pagination .page-item.active .page-link {
            background-color: #5E60CE;
            border-color: #5E60CE;
        }
    </style>

@endsection


