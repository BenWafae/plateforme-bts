@extends('layouts.admin')

@section('title', 'Gestion des Filières')

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
        .search-container {
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
            padding: 12px 20px;
            margin-bottom: 20px;
        }
        .filiere-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #5E60CE;
            transition: all 0.3s ease;
        }
        .filiere-card:hover {
            box-shadow: 0 8px 25px rgba(94, 96, 206, 0.2);
            transform: translateY(-2px);
        }
        .filiere-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
        }
        .filiere-icon {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
    </style>

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8 flex items-center justify-center">
            <i class="fas fa-graduation-cap text-violet-custom mr-3"></i>
            Gestion des Filières
        </h1>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert-success-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Champ de recherche -->
        <div class="search-container mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-3">
                    <label for="searchInput" class="text-violet-custom font-semibold mb-2 flex items-center">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher une filière
                    </label>
                    <form method="GET" action="{{ route('filiere.index') }}">
                        <input type="text" 
                               name="search" 
                               id="searchInput"
                               class="form-control form-control-custom w-full" 
                               placeholder="Rechercher une filière..." 
                               value="{{ request('search') }}">
                    </form>
                </div>
                <div class="text-right">
                    <a href="{{ route('filiere.form') }}" 
                       class="btn btn-violet-custom px-6 py-2 rounded-lg font-semibold flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-plus mr-2"></i>
                        Créer une Filière
                    </a>
                </div>
            </div>
        </div>

        {{-- Tableau des filières --}}
        <div class="filiere-card">
            <div class="overflow-x-auto">
                <table class="table-custom w-full">
                    <thead>
                        <tr>
                            <th class="text-left" style="width: 70%;">
                                <i class="fas fa-university mr-2"></i>
                                Nom de la Filière
                            </th>
                            <th class="text-center" style="width: 30%;">
                                <i class="fas fa-cogs mr-2"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filieres as $filiere)
                            <tr>
                                <td>
                                    <div class="filiere-name">
                                        <div class="filiere-icon">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        {{ $filiere->nom_filiere }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Modifier --}}
                                        <a href="{{ route('filiere.edit', $filiere->id_filiere) }}" 
                                           class="action-btn btn-edit" 
                                           title="Modifier la filière">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                         
                                        {{-- Supprimer --}}
                                        <form action="{{ route('filiere.destroy', $filiere->id_filiere)}}" 
                                              method="POST" 
                                              style="display:inline;" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-btn btn-delete" 
                                                    title="Supprimer la filière">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8">
                                    <div class="flex flex-col items-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-4 text-violet-custom opacity-50"></i>
                                        <p class="text-lg">Aucune filière trouvée</p>
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
        @if($filieres->hasPages())
            <div class="flex justify-center mt-6">
                <div class="bg-white rounded-lg shadow-md p-4 border-t-4 border-violet-custom">
                    {{ $filieres->links('pagination::bootstrap-4') }}
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











