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
        .from-violet-custom {
            --tw-gradient-from: #5E60CE;
            --tw-gradient-to: rgba(94, 96, 206, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-violet-custom {
            --tw-gradient-to: #5E60CE;
        }
        
        /* Animations et transitions */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(94, 96, 206, 0.15);
        }
        
        /* Style pour les badges de format */
        .format-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            padding: 0 12px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Styles pour les onglets */
        .custom-tabs .nav-link {
            color: #6b7280;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .custom-tabs .nav-link:hover {
            color: #5E60CE;
            border-bottom-color: rgba(94, 96, 206, 0.3);
        }
        
        .custom-tabs .nav-link.active {
            color: #5E60CE;
            background: transparent;
            border-bottom-color: #5E60CE;
        }
        
        /* Animation pour les filtres */
        .filter-container {
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.03) 0%, rgba(120, 121, 227, 0.06) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(94, 96, 206, 0.1);
        }
    </style>

    <div class="container mx-auto px-6 py-8">
        <!-- En-tête avec titre et animation -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Gestion des Supports Éducatifs</h1>
            <div class="w-24 h-1 bg-gradient-to-r from-violet-custom to-purple-600 mx-auto rounded-full"></div>
        </div>

        <!-- Messages d'alerte avec design moderne -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="ml-auto text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Section de filtrage modernisée -->
        <div class="filter-container p-6 rounded-2xl shadow-lg mb-8">
            <form method="GET" action="{{ route('admin.supports.index') }}">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <!-- Filtre par professeur -->
                        <div class="relative">
                            <select name="professeur_id" 
                                    class="appearance-none bg-white border border-gray-300 rounded-xl px-4 py-3 pr-8 focus:outline-none focus:ring-2 focus:ring-violet-custom focus:border-transparent transition-all duration-200 min-w-[280px]" 
                                    onchange="this.form.submit()">
                                <option value="">👨‍🏫 Sélectionner un professeur</option>
                                @foreach ($professeurs as $professeur)
                                    <option value="{{ $professeur->id_user }}" {{ request('professeur_id') == $professeur->id_user ? 'selected' : '' }}>
                                        {{ $professeur->nom }} {{ $professeur->prenom }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Filtre par format -->
                        <div class="relative">
                            <select name="format" 
                                    class="appearance-none bg-white border border-gray-300 rounded-xl px-4 py-3 pr-8 focus:outline-none focus:ring-2 focus:ring-violet-custom focus:border-transparent transition-all duration-200 min-w-[240px]" 
                                    onchange="this.form.submit()">
                                <option value="">📂 Sélectionner un format</option>
                                <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>📄 PDF</option>
                                <option value="ppt" {{ request('format') == 'ppt' ? 'selected' : '' }}>📊 PowerPoint</option>
                                <option value="word" {{ request('format') == 'word' ? 'selected' : '' }}>📝 Word</option>
                                <option value="lien_video" {{ request('format') == 'lien_video' ? 'selected' : '' }}>🎥 Vidéo</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Créer modernisé -->
                    <a href="{{ route('admin.support.create') }}" 
                       class="bg-gradient-to-r from-violet-custom to-purple-600 text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2 hover:from-purple-600 hover:to-violet-custom transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <i class="fas fa-plus"></i>
                        <span>Créer un support</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Contenu principal avec design modernisé -->
        @foreach ($matieres as $matiere)
            @php
                $supportsParType = $supportsParMatiereEtType->filter(function ($supports, $key) use ($matiere) {
                    return Str::startsWith($key, $matiere->id_Matiere . '-');
                });
            @endphp

            @if ($supportsParType->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-100">
                    <!-- En-tête de la matière -->
                    <div class="bg-gradient-to-r from-violet-custom to-purple-600 text-white p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{ $matiere->Nom }}</h3>
                                <p class="text-purple-100">Supports éducatifs disponibles</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Onglets modernisés -->
                        <ul class="nav nav-tabs custom-tabs border-0 mb-6" id="tabs-{{ $matiere->id_Matiere }}" role="tablist">
                            @php $first = true; @endphp
                            @foreach ($types as $type)
                                @php
                                    $supports = $supportsParType->get(
                                        $matiere->id_Matiere . '-' . $type->id_type,
                                        collect()
                                    );
                                @endphp
                                @if ($supports->isNotEmpty())
                                    <li class="nav-item mr-8" role="presentation">
                                        <button class="nav-link {{ $first ? 'active' : '' }} text-lg px-0 pb-3" 
                                                id="tab-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                                data-bs-toggle="tab" 
                                                data-bs-target="#content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                                type="button" 
                                                role="tab">
                                            {{ ucfirst($type->nom) }}
                                            <span class="ml-2 bg-violet-100 text-violet-600 px-2 py-1 rounded-full text-xs font-bold">
                                                {{ $supports->count() }}
                                            </span>
                                        </button>
                                    </li>
                                    @php $first = false; @endphp
                                @endif
                            @endforeach
                        </ul>

                        <!-- Contenu des onglets -->
                        <div class="tab-content" id="tabContent-{{ $matiere->id_Matiere }}">
                            @php $first = true; @endphp
                            @foreach ($types as $type)
                                @php
                                    $supports = $supportsParType->get(
                                        $matiere->id_Matiere . '-' . $type->id_type,
                                        collect()
                                    );
                                @endphp
                                @if ($supports->isNotEmpty())
                                    <div class="tab-pane fade {{ $first ? 'show active' : '' }}" 
                                         id="content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                         role="tabpanel">
                                      
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                            @foreach ($supports as $support)
                                                <div class="bg-white border border-gray-200 rounded-xl p-6 card-hover shadow-sm">
                                                    <div class="flex justify-between items-start mb-4">
                                                        <h5 class="text-lg font-semibold text-gray-800 flex-1 mr-3">{{ $support->titre }}</h5>
                                                        
                                                        @if($support->format === 'lien_video')
                                                            <span class="format-badge" style="background-color: #fef2f2; color: #dc2626;">
                                                                🎥 Vidéo
                                                            </span>
                                                        @elseif($support->format === 'pdf')
                                                            <span class="format-badge" style="background-color: #eff6ff; color: #2563eb;">
                                                                📄 PDF
                                                            </span>
                                                        @elseif($support->format === 'ppt')
                                                            <span class="format-badge" style="background-color: #f0fdf4; color: #16a34a;">
                                                                📊 PPT
                                                            </span>
                                                        @elseif($support->format === 'word')
                                                            <span class="format-badge" style="background-color: #fefce8; color: #ca8a04;">
                                                                📝 Word
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                    <p class="text-gray-600 mb-6 line-clamp-3">{{ $support->description }}</p>
                                                    
                                                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                                                        @if($support->format === 'lien_video' && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                                            <a href="{{ $support->lien_url }}" target="_blank" 
                                                               class="w-10 h-10 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-colors duration-200">
                                                                <i class="fab fa-youtube text-lg"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/' . $support->lien_url) }}"
                                                               class="w-10 h-10 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors duration-200"
                                                               target="{{ $support->format === 'pdf' ? '_blank' : '_self' }}"
                                                               @if ($support->format !== 'pdf') download @endif>
                                                                @if ($support->format === 'pdf')
                                                                    <i class="fas fa-eye text-lg"></i>
                                                                @else
                                                                    <i class="fas fa-download text-lg"></i>
                                                                @endif
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('admin.support.edit', $support->id_support) }}" 
                                                           class="w-10 h-10 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center transition-colors duration-200">
                                                            <i class="fas fa-edit text-lg"></i>
                                                        </a>

                                                        <form action="{{ route('admin.support.destroy', $support->id_support) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="w-10 h-10 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-colors duration-200" 
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?')">
                                                                <i class="fas fa-trash-alt text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @php $first = false; @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Pagination modernisée -->
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-xl shadow-lg p-4">
                {{ $matieres->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <style>
        /* Styles pour la pagination */
        .pagination {
            margin: 0;
        }
        
        .pagination .page-link {
            color: #5E60CE;
            border: none;
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .pagination .page-link:hover {
            background-color: rgba(94, 96, 206, 0.1);
            color: #4F50AD;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #5E60CE;
            border-color: #5E60CE;
            border-radius: 8px;
        }
        
        /* Style pour line-clamp */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection






