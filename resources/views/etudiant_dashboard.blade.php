@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid py-3 mb-4" style="background-color: rgb(8, 45, 82); border-radius: 10px;">
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
            <form method="GET" action="{{ route('etudiant.dashboard') }}" class="d-inline-block">
                <select name="annee" class="form-select" onchange="this.form.submit()" 
                    style="width: auto; padding: 8px; font-weight: bold;">
                    <option value="">Choisissez l'année</option>
                    <option value="1" {{ request('annee') == '1' ? 'selected' : '' }}>1ère année</option>
                    <option value="2" {{ request('annee') == '2' ? 'selected' : '' }}>2ème année</option>
                </select>
            </form>

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
                                <div class="d-flex justify-content-center">
    @if(strpos($support->format, 'pdf') !== false)
    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
       class="btn btn-outline-danger btn-sm" target="_blank">
        <i class="fas fa-file-pdf"></i> Voir PDF
    </a>

@elseif(strpos($support->format, 'ppt') !== false)
    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
       class="btn btn-outline-warning btn-sm">
        <i class="fas fa-file-powerpoint"></i> Télécharger PPT
    </a>

@elseif(strpos($support->format, 'word') !== false || strpos($support->format, 'doc') !== false)
    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
       class="btn btn-outline-primary btn-sm">
        <i class="fas fa-file-alt"></i> Télécharger Word
    </a>

@elseif(strpos($support->format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
       class="btn btn-outline-info btn-sm">
        <i class="fab fa-youtube"></i> Regarder
    </a>
@endif

                                </div>
           <a href="{{ route('etudiant.supports.showTranslateForm', ['id' => $support->id_support]) }}" 
                class="btn btn-outline-secondary btn-sm" title="Traduire">
          <i class="fas fa-language"></i>
        </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection

