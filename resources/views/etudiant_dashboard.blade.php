@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')
    <div class="content-header mb-4">
        @if(request('type_id'))
            <div class="selected-type-bar mb-3 p-2" style="background-color:rgb(4, 23, 43); color: white;">
                <h4 class="mb-0">
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
                <div class="card mb-3 shadow-sm h-100 d-flex flex-column position-relative border border-1 border-dark rounded-3" 
                     style="transition: transform 0.3s ease-in-out;">
                    
                    <!-- Contenu de la carte -->
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title fw-bold">{{ $support->titre }}</h5>
                        <p class="card-text text-muted small">{{ $support->description }}</p>
                        <div class="mt-auto">
                            @if(strpos($support->format, 'pdf') !== false)
                                <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" 
                                   class="btn btn-outline-danger btn-sm" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Voir PDF
                                </a>
                            @elseif(strpos($support->format, 'ppt') !== false)
                                <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-file-powerpoint"></i> Télécharger PPT
                                </a>
                            @elseif(strpos($support->format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                <a href="{{ $support->lien_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fab fa-youtube"></i> Regarder
                                </a>
                            @else
                                <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-file-alt"></i> Voir Word
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
