@extends('layouts.navbar')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">Résultats de la recherche : "{{ $search }}"</h3>

    <div class="row gy-4">
        {{-- Liste des supports --}}
        @forelse($supports as $support)
            <div class="col-md-4">
                <div class="card h-100 rounded-lg shadow-sm position-relative border-2" style="border-color: #5E60CE;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2">{{ $support->titre }}</h5>
                        <p class="text-muted small flex-grow-1 mb-3">{{ $support->matiere->Nom ?? 'Matière inconnue' }}</p>
                        <div class="mt-auto d-flex gap-2 flex-wrap justify-content-center">

                            {{-- Lien selon le format --}}
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

                            {{-- Bouton de traduction --}}
                            <a href="{{ route('etudiant.supports.showTranslateForm', ['id' => $support->id_support]) }}" class="btn btn-outline-secondary btn-sm" title="Traduire">
                                <i class="fas fa-language"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-600">Aucun support trouvé pour cette recherche.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($supports instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $supports->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    @endif

</div>

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
</style>
