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

    <div class="row">
        @foreach($supports as $support)
            @if($support->id_type == request('type_id'))
                <div class="col-md-4 mb-4">
                    <!-- Carte avec un cadre noir -->
                    <div class="card border border-dark shadow-sm h-100" style="border-radius: 0px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $support->titre }}</h5>
                            <!-- Ligne de séparation en gras et bleu marine -->
                            <hr style="border: 3px solid #003366; margin: 10px 0;">
                            <p class="card-text">{{ $support->description }}</p>

                            <!-- Boutons alignés à droite -->
                            <div class="d-flex justify-content-end">
                                @if(strpos($support->format, 'pdf') !== false)
                                    <!-- Bouton PDF -->
                                    <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" 
                                       class="btn btn-outline-danger btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                @elseif(strpos($support->format, 'lien_video') !== false)
                                    <!-- Bouton YouTube -->
                                    <a href="{{ $support->lien_url }}" class="btn btn-outline-danger btn-sm" target="_blank">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @else
                                    <!-- Bouton pour autres formats (Télécharger) -->
                                    <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i>
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
