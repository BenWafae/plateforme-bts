@extends('layouts.sidbar')

@section('title', 'Supports éducatifs')

@section('content')
    <div class="content-header mb-4">
        <h2>Supports éducatifs</h2>
        <p>Consultez vos supports en cliquant sur les matières et les types de supports.</p>
    </div>

    @if(request('type_id'))
        <div class="selected-type-bar mb-3">
            <h4><i class="fas fa-file-alt"></i> 
            @foreach($types as $type)
                @if($type->id_type == request('type_id'))
                    {{ $type->nom }}
                @endif
            @endforeach
            </h4>
        </div>

        <div class="row">
            @foreach($supports as $support)
                @if($support->id_type == request('type_id'))
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title">{{ $support->titre }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $support->description }}</p>

                                <!-- Bouton Ouvrir ou Télécharger -->
                                @if(strpos($support->format, 'pdf') !== false)
                                    <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-eye"></i> Ouvrir
                                    </a>
                                @else
                                    <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" class="btn btn-outline-success">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <p>Aucun support disponible pour ce type.</p>
    @endif
@endsection
