@extends('layouts.admin')

@section('content')

<div class="container">
    <h2 class="text-center">Gestion des Supports Éducatifs</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtrage par professeur et format -->
    <form method="GET" action="{{ route('admin.supports.index') }}" class="mb-3" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <div class="d-flex justify-content-between align-items-center" style="gap: 15px;">
            <div class="d-flex">
                <!-- Filtrer par professeur -->
                <select name="professeur_id" class="form-select me-3" onchange="this.form.submit()" 
                        style="border-radius: 5px; border: 1px solid #ced4da; padding: 8px 15px; font-size: 16px; width: 280px; margin-right: 15px;">
                    <option value="">Sélectionner un professeur</option>
                    @foreach ($professeurs as $professeur)
                        <option value="{{ $professeur->id_user }}" {{ request('professeur_id') == $professeur->id_user ? 'selected' : '' }}>
                            {{ $professeur->nom }} {{ $professeur->prenom }}
                        </option>
                    @endforeach
                </select>

                <!-- Filtrer par format -->
                <select name="format" class="form-select me-3" onchange="this.form.submit()" style="border-radius: 5px; border: 1px solid #ced4da; padding: 8px 15px; font-size: 16px; width: 240px; margin-right: 15px;">
                    <option value="">📂 Sélectionner un format</option>
                    <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>📄 PDF</option>
                    <option value="ppt" {{ request('format') == 'ppt' ? 'selected' : '' }}>📊 PPT</option>
                    <option value="word" {{ request('format') == 'word' ? 'selected' : '' }}>📝 Word</option>
                    <option value="lien_video" {{ request('format') == 'lien_video' ? 'selected' : '' }}>🎥 Vidéo</option>
                </select>
            </div>

            <!-- Bouton Créer -->
            <a href="{{ route('admin.support.create') }}" class="btn btn-link" style="color: #007bff; font-size: 16px; padding: 8px 20px; text-decoration: none; border: none; transition: color 0.3s ease;">
                <i class="fas fa-plus"></i> Créer
            </a>
        </div>
    </form>

    @foreach ($matieres as $matiere)
        @php
            $supportsParType = $supportsParMatiereEtType->filter(function ($supports, $key) use ($matiere) {
                return Str::startsWith($key, $matiere->id_Matiere . '-');
            });
        @endphp

        @if ($supportsParType->isNotEmpty())
            <div class="card mt-5">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0">{{ $matiere->Nom }}</h3>
                </div>
                <div class="card-body">

                    <!-- Onglets (Cours, Exercices, Examens) -->
                    <ul class="nav nav-tabs" id="tabs-{{ $matiere->id_Matiere }}" role="tablist">
                        @php $first = true; @endphp
                        @foreach ($types as $type)
                            @php
                                $supports = $supportsParType->get(
                                    $matiere->id_Matiere . '-' . $type->id_type,
                                    collect()
                                );
                            @endphp
                            @if ($supports->isNotEmpty())
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $first ? 'active' : '' }}" 
                                            id="tab-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                            data-bs-toggle="tab" 
                                            data-bs-target="#content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                            type="button" 
                                            role="tab" 
                                            aria-controls="content-{{ $matiere->id_Matiere }}-{{ $type->id_type }}" 
                                            aria-selected="{{ $first ? 'true' : 'false' }}">
                                        {{ ucfirst($type->nom) }}
                                    </button>
                                </li>
                                @php $first = false; @endphp
                            @endif
                        @endforeach
                    </ul>

                    <!-- Contenu des onglets -->
                    <div class="tab-content mt-3" id="tabContent-{{ $matiere->id_Matiere }}">
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
                                     role="tabpanel" 
                                     aria-labelledby="tab-{{ $matiere->id_Matiere }}-{{ $type->id_type }}">
                                  
                                    <div class="row mt-2 mb-2 gy-3">
                                        @foreach ($supports as $support)
                                            <div class="col-md-4">
                                                <div class="card mb-3 shadow-sm h-100 d-flex flex-column">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="d-flex justify-content-between">
                                                            <h5 class="card-title">{{ $support->titre }}</h5>
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
                                                        <div class="d-flex justify-content-end gap-2 mt-auto">
                                                            @if($support->format === 'lien_video' && filter_var($support->lien_url, FILTER_VALIDATE_URL))
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
                                                                        <!-- Icône Ouvrir avec lien vers PDF -->
                                                                        <i class="fas fa-eye"></i> 
                                                                    @elseif ($support->format === 'ppt')
                                                                        <!-- Icône de téléchargement pour PPT -->
                                                                        <i class="fas fa-download"></i>
                                                                    @elseif ($support->format === 'word')
                                                                        <!-- Icône de téléchargement pour Word -->
                                                                        <i class="fas fa-download"></i>
                                                                    @endif
                                                                </a>
                                                            @endif

                                                            <!-- Bouton de modification -->
                                                            <a href="{{ route('admin.support.edit', $support->id_support) }}" class="btn text-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <!-- Formulaire de suppression -->
                                                            <form action="{{ route('admin.support.destroy', $support->id_support) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
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

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3 mb-5">
        <nav>
            <ul class="pagination pagination-sm justify-content-center">
                {{ $matieres->links('pagination::bootstrap-4') }}
            </ul>
        </nav>
    </div>
</div>

@endsection








