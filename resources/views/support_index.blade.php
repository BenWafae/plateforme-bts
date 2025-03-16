@extends('layouts.professeur')

@section('content')
    <div class="container">
        <h2>Mes Supports de Cours</h2>

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

        @foreach ($matieres as $matiere)
            @php
                // Filtrage des supports par type pour chaque matière
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

                        {{-- Onglets pour chaque type de support --}}
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
                                            {{ ucfirst($type->nom) }}
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        {{-- Contenu des onglets --}}
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
                                                                {{-- Affichage du badge si le support est une vidéo --}}
                                                                @if($support->format === 'lien_video')
                                                                <span class="badge" style="background-color: #f0f9ff; color: #3d7ca6">Vidéo</span>
                                                                      @endif
                                                            </div>
                                                            
                                                            <p class="card-text flex-grow-1">{{ $support->description }}</p>

                                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                                @if($support->format === 'lien_video' && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                                                    {{-- Bouton pour rediriger vers YouTube --}}
                                                                    <a href="{{ $support->lien_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                                        Voir sur YouTube
                                                                    </a>
                                                                @else
                                                                    {{-- Lien de téléchargement ou ouverture pour les autres formats --}}
                                                                    <a href="{{ asset('storage/' . $support->lien_url) }}"
                                                                       class="btn btn-sm {{ $support->format === 'pdf' ? 'btn-outline-primary' : 'btn-outline-success' }} "
                                                                       target="{{ $support->format === 'pdf' ? '_blank' : '_self' }}"
                                                                       @if ($support->format !== 'pdf') download @endif>
                                                                        @if ($support->format === 'pdf')
                                                                            📄 Ouvrir
                                                                        @else
                                                                            ⬇ Télécharger
                                                                        @endif
                                                                    </a>
                                                                @endif

                                                                {{-- Bouton de modification --}}
                                                                <a href="{{ route('supports.edit', $support->id_support) }}" 
                                                                   class="btn btn-sm btn-outline-warning" title="Modifier">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                {{-- Formulaire de suppression --}}
                                                                <form action="{{ route('supports.destroy', $support->id_support) }}" method="POST" class="d-inline">
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





