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

    <form method="GET" action="{{ route('admin.supports.index') }}" class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                
    
                {{-- Filtre par Professeur --}}
                <select name="professeur_id" class="form-select me-3" onchange="this.form.submit()">
                    <option value="">Sélectionner un professeur</option>
                    @foreach ($professeurs as $professeur)
                        <option value="{{ $professeur->id_user }}" {{ request('professeur_id') == $professeur->id_user ? 'selected' : '' }}>
                            {{ $professeur->nom }} {{ $professeur->prenom }}
                        </option>
                    @endforeach
                </select>
    
                {{-- Filtre par Format --}}
                <select name="format" class="form-select me-3" onchange="this.form.submit()">
                    <option value="">Sélectionner un format</option>
                    <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="ppt" {{ request('format') == 'ppt' ? 'selected' : '' }}>PPT</option>
                    <option value="word" {{ request('format') == 'word' ? 'selected' : '' }}>Word</option>
                    <option value="lien_video" {{ request('format') == 'lien_video' ? 'selected' : '' }}>Vidéo</option>
                </select>
            </div>
    
          
    
            {{-- Bouton Créer --}}
            <a href="{{ route('admin.support.create') }}" class="btn btn-primary">
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

                    {{-- Onglets (Cours, Exercices, Examens) --}}
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

                    {{-- Contenu des onglets --}}
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
                                                                <span class="badge bg-info text-dark">Vidéo</span>
                                                            @endif
                                                        </div>
                                                        <p class="card-text flex-grow-1">{{ $support->description }}</p>
                                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                                            @if($support->format === 'lien_video' && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                                                <a href="{{ $support->lien_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                                    Voir sur YouTube
                                                                </a>
                                                            @else
                                                                <a href="{{ asset('storage/' . $support->lien_url) }}"
                                                                   class="btn btn-sm {{ $support->format === 'pdf' ? 'btn-outline-primary' : 'btn-outline-success' }} "
                                                                   target="{{ $support->format === 'pdf' ? '_blank' : '_self' }} "
                                                                   @if ($support->format !== 'pdf') download @endif>
                                                                    @if ($support->format === 'pdf')
                                                                        📄 Ouvrir
                                                                    @else
                                                                        ⬇ Télécharger
                                                                    @endif
                                                                </a>
                                                            @endif

                                                            {{-- Bouton de modification --}}
                                                            <a href="{{ route('admin.support.edit', $support->id_support) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            {{-- Formulaire de suppression --}}
                                                            <form action="{{ route('admin.support.destroy', $support->id_support) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?')" 
                                                                    title="Supprimer">
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

  {{-- Pagination avec marge supplémentaire pour espacement --}}
<div class="d-flex justify-content-center mt-3 mb-5">
    <nav>
        <ul class="pagination pagination-sm justify-content-center">
            {{ $matieres->links('pagination::bootstrap-4') }}
        </ul>
    </nav>
</div>
    
</div>

@endsection


