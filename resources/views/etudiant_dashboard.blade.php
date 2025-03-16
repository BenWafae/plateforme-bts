@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')
    <div class="content-header mb-4">
        <!-- Affichage du type de support sélectionné dans une barre -->
        @if(request('type_id'))
            <div class="selected-type-bar mb-3 p-2" style="background-color:rgb(4, 23, 43); color: white;">
                <h4 class="mb-0">
                    <i class="fas fa-file-alt"></i> 
                    @foreach($types as $type)
                        @if($type->id_type == request('type_id'))
                            {{ $type->nom }}
                        @endif
                    @endforeach
                </h4>
            </div>
        @endif
    </div>

    <div class="row mt-2 mb-2 gy-3">
        @foreach($supports as $support)
            @if($support->id_type == request('type_id'))
                <div class="col-md-4">
                    <!-- Carte avec une bordure noire -->
                    <div class="card mb-3 shadow-sm h-100 d-flex flex-column" style="border: 2px solid black; border-radius: 5px;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ $support->titre }}</h5>
                                @if($support->format === 'lien_video')
                                    <span class="badge bg-info text-dark">Vidéo</span>
                                @endif
                            </div>

                            <!-- La ligne de séparation a été supprimée -->

                            <p class="card-text flex-grow-1">{{ $support->description }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                @if(strpos($support->format, 'pdf') !== false)
                                    <!-- Bouton PDF -->
                                    <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" 
                                       class="btn btn-outline-danger btn-sm" target="_blank">
                                        📄 Ouvrir
                                    </a>
                                @elseif(strpos($support->format, 'lien_video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                    <!-- Bouton YouTube -->
                                    <a href="{{ $support->lien_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        Voir sur YouTube
                                    </a>
                                @else
                                    <!-- Bouton pour autres formats (Télécharger) -->
                                    <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        ⬇ Télécharger
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
