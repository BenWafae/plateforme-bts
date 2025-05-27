@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Barre de filtres --}}
<div class="container py-3 mb-4 rounded-3 text-white" style="background-color: #5E60CE;">
    <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
        {{-- Formulaire d’année --}}
        <form method="GET" action="{{ route('etudiant.dashboard') }}" class="d-inline-block">
            <select name="annee" class="form-select fw-bold" onchange="this.form.submit()" style="width: auto;">
                <option value="">Choisissez l'année</option>
                <option value="1" {{ request('annee') == '1' ? 'selected' : '' }}>1ère année</option>
                <option value="2" {{ request('annee') == '2' ? 'selected' : '' }}>2ème année</option>
            </select>
        </form>

        {{-- Dropdowns --}}
        @if(request('annee'))
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle fw-bold" type="button" id="filiereDropdown" data-bs-toggle="dropdown">
                    Filière
                </button>
                <ul class="dropdown-menu" aria-labelledby="filiereDropdown">
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
                <button class="btn btn-outline-light dropdown-toggle fw-bold" type="button" id="matiereDropdown" data-bs-toggle="dropdown">
                    Matière
                </button>
                <ul class="dropdown-menu" aria-labelledby="matiereDropdown">
                    @foreach($matières as $matiere)
                        <li>
                            <a class="dropdown-item {{ request('matiere_id') == $matiere->id_Matiere ? 'active' : '' }}"
                               href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => request('filiere_id'), 'matiere_id' => $matiere->id_Matiere]) }}">
                                {{ $matiere->Nom }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(request('matiere_id'))
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle fw-bold" type="button" id="typeDropdown" data-bs-toggle="dropdown">
                    Type de support
                </button>
                <ul class="dropdown-menu" aria-labelledby="typeDropdown">
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

@if(!request('annee') || !request('filiere_id') || !request('matiere_id') || !request('type_id'))
    {{-- Instructions --}}
    <div class="container text-center py-5">
        <div class="border rounded-4 p-5 shadow-sm" style="max-width: 720px; margin: auto; background-color: #E9ECFF; border-color: #5E60CE;">
            <p class="text-dark fw-semibold fs-5 mb-4">
                Veuillez suivre les étapes ci-dessous pour afficher les supports pédagogiques :
            </p>
            <ul class="text-start text-dark fw-normal fs-6 ps-3">
                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Sélectionnez l’<strong>année d’étude</strong></li>
                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Choisissez la <strong>filière</strong> correspondante</li>
                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Sélectionnez la <strong>matière</strong></li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Définissez le <strong>type de support</strong></li>
            </ul>
        </div>
    </div>
@else
    {{-- Affichage des supports --}}
    <div class="container">
        <div class="row g-4">
            @forelse($supports as $support)
                <div class="col-md-4">
                    <div class="card h-100 rounded-lg shadow-sm transition-shadow hover:shadow-md position-relative border-2" style="border-color: #5E60CE;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">{{ $support->titre }}</h5>
                            <p class="text-muted small flex-grow-1 mb-3">{{ $support->matiere->Nom ?? 'Matière inconnue' }}</p>
                            <div class="mt-auto d-flex gap-2 flex-wrap justify-content-center">
                                @if(strpos($support->format, 'pdf') !== false)
                                    <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" class="btn btn-outline-danger btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Voir PDF
                                    </a>
                                @elseif(strpos($support->format, 'ppt') !== false)
                                    <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-file-powerpoint"></i> Télécharger PPT
                                    </a>
                                @elseif(strpos($support->format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                    <a href="{{ $support->lien_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="fab fa-youtube"></i> Regarder
                                    </a>
                                @else
                                    <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-file-alt"></i> Télécharger Word
                                    </a>
                                @endif
                                <a href="{{ route('etudiant.supports.showTranslateForm', ['id' => $support->id_support]) }}" class="btn btn-outline-secondary btn-sm" title="Traduire">
                                    <i class="fas fa-language"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">Aucun support trouvé pour ces critères.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
       @if($supports instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="d-flex justify-content-center mt-4">
        {{ $supports->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
@endif

    </div>
@endif

@endsection

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Styles supplémentaires pour la pagination --}}
<style>
    nav ul.pagination {
        display: flex;
        gap: 0.5rem;
        padding-left: 0;
        list-style: none;
    }
    nav ul.pagination li a,
    nav ul.pagination li span {
        padding: 0.5rem 0.75rem;
        border: 2px solid #5E60CE;
        color: #5E60CE;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s, color 0.2s;
        text-decoration: none;
    }
    nav ul.pagination li a:hover {
        background-color: #5E60CE;
        color: white;
    }
    nav ul.pagination li.active span {
        background-color: #5E60CE;
        color: white;
        border-color: #5E60CE;
        cursor: default;
    }
</style>