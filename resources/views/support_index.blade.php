@extends('layouts.professeur')

@section('head')
    <style>
        /* Configuration des couleurs personnalisées pour le thème violet */
        .bg-violet-custom {
            background-color: #5E60CE;
        }
        .text-violet-custom {
            color: #5E60CE;
        }
        .border-violet-custom {
            border-color: #5E60CE;
        }

        /* Style pour le titre principal avec thème violet */
        .main-title {
            color: #5E60CE;
            font-weight: bold;
            text-shadow: 0 1px 3px rgba(94, 96, 206, 0.1);
        }

        /* Style pour les en-têtes de matières avec gradient violet */
        .matiere-header {
            background: linear-gradient(135deg, #5E60CE 0%, #7C3AED 100%);
        }

        /* Style pour les onglets avec couleur violet */
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #5E60CE;
            border-bottom-color: rgba(94, 96, 206, 0.3);
        }

        .nav-tabs .nav-link.active {
            color: #5E60CE;
            border-bottom-color: #5E60CE;
            background-color: transparent;
            font-weight: 600;
        }

        /* Style pour le formulaire de filtrage avec accent violet */
        .filter-form {
            border-left: 4px solid #5E60CE;
        }

        .filter-label {
            color: #5E60CE;
            font-weight: bold;
        }

        /* Style pour la pagination avec thème violet */
        .pagination .page-link {
            color: #5E60CE;
            border-color: #dee2e6;
            transition: all 0.2s ease;
            border-radius: 0.375rem;
            margin: 0 0.125rem;
        }

        .pagination .page-link:hover {
            color: white;
            background-color: #5E60CE;
            border-color: #5E60CE;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(94, 96, 206, 0.3);
        }

        .pagination .page-item.active .page-link {
            background-color: #5E60CE;
            border-color: #5E60CE;
            color: white;
            box-shadow: 0 4px 8px rgba(94, 96, 206, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: #f9fafb;
            border-color: #e5e7eb;
        }

        /* Style pour le bouton nouveau support */
        .btn-violet {
            background-color: #5E60CE;
            border-color: #5E60CE;
            color: white;
            transition: all 0.2s ease;
        }

        .btn-violet:hover {
            background-color: #4F50AD;
            border-color: #4F50AD;
            color: white;
            transform: translateY(-1px);
        }

        /* Badge avec compteur violet */
        .badge-count {
            background-color: rgba(94, 96, 206, 0.1);
            color: #5E60CE;
            border: 1px solid rgba(94, 96, 206, 0.2);
        }
    </style>
@endsection

@section('breadcrumb', 'Mes Supports de Cours')

@section('content')
    <div class="container">
        <h2 class="main-title mb-4">
            <i class="fas fa-folder-open me-2"></i>
            Mes Supports de Cours
        </h2>

       {{-- Formulaire de filtrage avec accent violet --}}
       <form method="GET" action="{{ route('supports.index') }}" class="mb-4 filter-form" 
       style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; 
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
       
       <div class="row align-items-center">
           <div class="col-md-4">
               <label for="format" class="form-label filter-label">
                   <i class="fas fa-filter me-1"></i>
                   Filtrer par Format
               </label>
               <select name="format" id="format" class="form-select" onchange="this.form.submit()" 
                   style="border-radius: 5px; border: 1px solid #ced4da; padding: 10px 15px; font-size: 16px; 
                          background-color: white; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;
                          border-left: 3px solid #5E60CE;">
                   <option value="">📂 Tous les formats</option>
                   <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>📄 PDF</option>
                   <option value="ppt" {{ request('format') == 'ppt' ? 'selected' : '' }}>📊 PPT</option>
                   <option value="word" {{ request('format') == 'word' ? 'selected' : '' }}>📝 Word</option>
                   <option value="lien_video" {{ request('format') == 'lien_video' ? 'selected' : '' }}>🎥 Vidéo</option>
               </select>
           </div>
           <div class="col-md-8 text-end">
               <a href="{{ route('supports.create') }}" class="btn btn-violet">
                   <i class="fas fa-plus me-2"></i>
                   Nouveau Support
               </a>
           </div>
       </div>
   </form>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @foreach ($matieres as $matiere)
            @php
                // Filtrage des supports par type pour chaque matière
                $supportsParType = $supportsParMatiereEtType->filter(function ($supports, $key) use ($matiere) {
                    return Str::startsWith($key, $matiere->id_Matiere . '-');
                });
            @endphp

            @if ($supportsParType->isNotEmpty())
                <div class="card mt-5">
                    <div class="card-header matiere-header text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">
                                <i class="fas fa-book me-2"></i>
                                {{ $matiere->Nom }}
                            </h3>
                            <span class="badge bg-white text-violet-custom">
                                {{ $supportsParType->flatten()->count() }} supports
                            </span>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Onglets pour chaque type de support avec style violet --}}
                        <ul class="nav nav-tabs" id="tabsMatiere{{ $matiere->id_Matiere }}" role="tablist">
                            @foreach ($types as $index => $type)
                                @php
                                    $supports = $supportsParType->get(
                                        $matiere->id_Matiere . '-' . $type->id_type,
                                        collect()
                                    );
                                @endphp
                                @if ($supports->isNotEmpty())
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($index === 0) active @endif" 
                                                id="tab-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                                data-bs-toggle="tab" 
                                                data-bs-target="#content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                                type="button" 
                                                role="tab" 
                                                aria-controls="content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                            <i class="fas fa-folder me-1"></i>
                                            {{ ucfirst($type->nom) }}
                                            <span class="badge badge-count ms-2">
                                                {{ $supports->count() }}
                                            </span>
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        {{-- Contenu des onglets - CARTES INCHANGÉES --}}
                        <div class="tab-content mt-3" id="tabsContentMatiere{{ $matiere->id_Matiere }}">
                            @foreach ($types as $index => $type)
                                @php
                                    $supports = $supportsParType->get(
                                        $matiere->id_Matiere . '-' . $type->id_type,
                                        collect()
                                    );
                                @endphp
                                @if ($supports->isNotEmpty())
                                    <div class="tab-pane fade @if($index === 0) show active @endif" 
                                         id="content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                         role="tabpanel" 
                                         aria-labelledby="tab-{{ $matiere->id_Matiere }}-{{ $type->id_type }}">

                                        <div class="row mt-2 mb-2 gy-3">
                                            @foreach ($supports as $support)
                                                <div class="col-md-4">
                                                    <div class="card mb-3 shadow-sm h-100 d-flex flex-column">
                                                        <div class="card-body d-flex flex-column">
                                                            
                                                            <div class="d-flex justify-content-between">
                                                                <h5 class="card-title">{{ $support->titre }}</h5>
                                                                {{-- badge vediooo --}}
                                                                @if($support->format === 'lien_video')
                                                            <span class="badge" style="display: flex; align-items: center; justify-content: center; background-color: oklch(0.971 0.013 17.38); color: oklch(0.577 0.245 27.325);  height: 30px; line-height: 30px; padding: 0 10px;">
                                                                Vidéo
                                                            </span>
                                                            
                                                            @elseif($support->format === 'pdf')
                                                                <!-- Badge PDF sans icône, icône "Ouvrir" dans le bouton -->
                                                                <span class="badge" style="display: flex; align-items: center; justify-content: center; background-color: oklch(0.984 0.019 200.873); color: oklch(0.746 0.16 232.661);  height: 30px; line-height: 30px; padding: 0 10px;">
                                                                    PDF
                                                                </span>
                                                            @elseif($support->format === 'ppt')
                                                                <!-- Badge PPT avec couleur spécifique -->
                                                                <span class="badge" style="background-color:oklch(0.979 0.021 166.113); color: oklch(0.765 0.177 163.223); display: flex; align-items: center; justify-content: center; height: 30px; line-height: 35px; padding: 0 10px;">
                                                                    PPT
                                                                </span>
                                                                
                                                                
                                                            @elseif($support->format === 'word')
                                                                <!-- Badge Word avec couleur spécifique -->
                                                                <span class="badge" style="background-color: oklch(0.967 0.001 286.375);color: oklch(0.705 0.015 286.067); display: flex; align-items: center; justify-content: center; height: 35px; line-height: 30px; padding: 0 10px;">
                                                                    Word
                                                                </span>
                                                            @endif
                                                            </div>
                                                            
                                                            <p class="card-text flex-grow-1">{{ $support->description }}</p>
                                                            <div class="d-flex justify-content-end align-items-center mt-auto">
                                                                @if($support->format === 'lien_video' && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                                                    {{-- Bouton pour rediriger vers YouTube --}}
                                                                    <a href="{{ $support->lien_url }}" target="_blank" class="btn text-danger">
                                                                        <i class="fab fa-youtube"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ asset('storage/' . $support->lien_url) }}"
                                                                       class="btn"
                                                                       target="{{ $support->format === 'pdf' ? '_blank' : '_self' }} "
                                                                       @if ($support->format !== 'pdf') download @endif 
                                                                       style="color: inherit;">
                                                                        @if ($support->format === 'pdf')
                                                                            <i class="fas fa-eye"></i> 
                                                                        @elseif ($support->format === 'ppt')
                                                                            <i class="fas fa-download"></i>
                                                                        @elseif ($support->format === 'word')
                                                                            <i class="fas fa-download"></i>
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                            
                                                                {{-- Tous les boutons (Ouvrir, Modifier, Supprimer) alignés à droite --}}
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    {{-- Bouton de modification avec la couleur de l'icône --}}
                                                                    <a href="{{ route('supports.edit', $support->id_support) }}" 
                                                                       class="btn btn-sm btn-outline-warning" 
                                                                       style="border: none; background-color: transparent;" 
                                                                       title="Modifier">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                            
                                                                    {{-- Formulaire de suppression avec la couleur de l'icône --}}
                                                                    <form action="{{ route('supports.destroy', $support->id_support) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                                style="border: none; background-color: transparent;"
                                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?')" 
                                                                                title="Supprimer">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif
        @endforeach

        {{-- Pagination stylisée avec thème violet --}}
        <div class="d-flex justify-content-center mt-5 mb-5">
            <nav aria-label="Navigation des supports">
                <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden p-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="text-violet-custom me-3 fw-bold">
                            <i class="fas fa-file-alt me-1"></i>
                            Pages :
                        </span>
                        {{ $matieres->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </nav>
        </div>
    </div>
@endsection






