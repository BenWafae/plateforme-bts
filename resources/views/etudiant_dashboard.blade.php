@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')

<!-- Barre de sélection -->
<div class="container-fluid py-3 mb-4" style="background-color: rgb(8, 45, 82); border-radius: 10px;">
    <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">

        <!-- Sélecteur Année -->
        <form method="GET" action="{{ route('etudiant.dashboard') }}" class="d-inline-block">
            <select name="annee" class="form-select" onchange="this.form.submit()" 
                style="width: auto; padding: 8px; font-weight: bold;">
                <option value="">Choisissez l'année</option>
                <option value="1" {{ request('annee') == '1' ? 'selected' : '' }}>1ère année</option>
                <option value="2" {{ request('annee') == '2' ? 'selected' : '' }}>2ème année</option>
            </select>
        </form>

        <!-- Sélecteur Filière -->
        @if(request('annee'))
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle px-4 py-2 fw-bold" type="button" 
                    id="filiereDropdown" data-bs-toggle="dropdown">
                    Filière
                </button>
                <ul class="dropdown-menu">
                    @foreach($filieres as $filiere)
                        <li>
                            <a class="dropdown-item {{ request('filiere_id') == $filiere->id_filiere ? 'active' : '' }}"
                                href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => $filiere->id_filiere]) }}">
                                {{ $filiere->nom_filiere }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Sélecteur Matière -->
        @if(request('filiere_id'))
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle px-4 py-2 fw-bold" type="button" 
                    id="matiereDropdown" data-bs-toggle="dropdown">
                    Matière
                </button>
                <ul class="dropdown-menu">
                    @foreach($matières as $matiere)
                        <li>
                            <a class="dropdown-item {{ request('matiere_id') == $matiere->id_Matiere ? 'active' : '' }}"
                                href="{{ route('etudiant.dashboard', [
                                    'annee' => request('annee'),
                                    'filiere_id' => request('filiere_id'),
                                    'matiere_id' => $matiere->id_Matiere
                                ]) }}">
                                {{ $matiere->Nom }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Sélecteur Type de Support -->
        @if(request('matiere_id'))
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle px-4 py-2 fw-bold" type="button" 
                    id="typeDropdown" data-bs-toggle="dropdown">
                    Type de support
                </button>
                <ul class="dropdown-menu">
                    @foreach($types as $type)
                        <li>
                            <a class="dropdown-item {{ request('type_id') == $type->id_type ? 'active' : '' }}"
                                href="{{ route('etudiant.dashboard', [
                                    'annee' => request('annee'),
                                    'filiere_id' => request('filiere_id'),
                                    'matiere_id' => request('matiere_id'),
                                    'type_id' => $type->id_type
                                ]) }}">
                                {{ $type->nom }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>

<!-- Affichage des supports -->
<div class="row mt-2 mb-2 gy-3">
    @foreach($supports as $support)
        @if($support->id_type == request('type_id'))
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm h-100 d-flex flex-column position-relative border border-1 border-dark rounded-3"
                    style="transition: transform 0.3s ease-in-out;">
                    
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