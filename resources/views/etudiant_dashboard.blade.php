@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')

{{-- Message de succès --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Barre de filtres --}}
<div class="container py-3 mb-4 rounded-3 text-white" style="background-color: #5E60CE;">
    <div class="d-flex align-items-center justify-content-center gap-3 flex-nowrap">

        {{-- Filtre : Matière --}}
        @if($matières->count())
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle fw-bold" type="button" id="matiereDropdown" data-bs-toggle="dropdown">
                    Matière
                </button>
                <ul class="dropdown-menu" aria-labelledby="matiereDropdown">
                    @foreach($matières as $matiere)
                        <li>
                            <a class="dropdown-item {{ request('matiere_id') == $matiere->id_Matiere ? 'active' : '' }}"
                               href="{{ route('etudiant.dashboard', ['matiere_id' => $matiere->id_Matiere]) }}">
                                {{ $matiere->Nom }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Filtre : Type de support --}}
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

{{-- Instructions ou affichage des supports --}}
@if(!request('matiere_id') || !request('type_id'))
    <div class="container text-center py-5">
        <div class="border rounded-4 p-5 shadow-sm" style="max-width: 720px; margin: auto; background-color: #E9ECFF; border-color: #5E60CE;">
            <p class="text-dark fw-semibold fs-5 mb-4">Veuillez suivre les étapes ci-dessous pour afficher les supports pédagogiques :</p>
            <ul class="text-start text-dark fw-normal fs-6 ps-3">
                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Choisissez une <strong>matière</strong></li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Sélectionnez le <strong>type de support</strong></li>
            </ul>
        </div>
    </div>
@else
    <div class="container">
        <div class="row g-4">

            {{-- Liste des supports --}}
            @forelse($supports as $support)
                <div class="col-md-4">
                    <div class="card h-100 rounded-lg shadow-sm position-relative border-2" style="border-color: #5E60CE;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">{{ $support->titre }}</h5>
                            <p class="text-muted small flex-grow-1 mb-3">{{ $support->matiere->Nom ?? 'Matière inconnue' }}</p>
                            <div class="mt-auto d-flex gap-2 flex-wrap justify-content-center">

                                @php $format = strtolower($support->format); @endphp

                                @if(strpos($format, 'pdf') !== false)
                                    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" class="btn btn-outline-danger btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Voir PDF
                                    </a>
                                @elseif(strpos($format, 'ppt') !== false)
                                    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-file-powerpoint"></i> Télécharger PPT
                                    </a>
                                @elseif(strpos($format, 'word') !== false || strpos($format, 'doc') !== false)
                                    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-file-alt"></i> Télécharger Word
                                    </a>
                                @elseif(strpos($format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                    <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" class="btn btn-outline-info btn-sm">
                                        <i class="fab fa-youtube"></i> Regarder
                                    </a>
                                @endif

                                {{-- Traduction --}}
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

{{-- Scripts Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Styles pagination --}}
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

    @media (max-width: 768px) {
        .d-flex.align-items-center.justify-content-center.gap-3.flex-nowrap {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .dropdown .btn,
        .form-select {
            width: 100% !important;
        }

        .container.py-3.mb-4.rounded-3.text-white {
            padding: 1rem !important;
        }

        .card .btn {
            width: 100%;
        }

        .card .d-flex.flex-wrap.justify-content-center {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
