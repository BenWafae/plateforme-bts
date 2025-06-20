@extends('layouts.navbar')

@section('title', 'Supports éducatifs')

@section('content')

{{-- Message de succès --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-left: 4px solid #28a745 !important;">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Header avec titre et description --}}
<div class="hero-section mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 4rem 0;">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold mb-3">Supports Éducatifs</h1>
        <p class="lead mb-0 opacity-90">Accédez à vos ressources pédagogiques en quelques clics</p>
    </div>
</div>

{{-- Barre de filtres modernisée --}}
<div class="container mb-5">
    <div class="filter-card bg-white rounded-4 shadow-lg p-4 border-0" style="backdrop-filter: blur(20px); background: rgba(255, 255, 255, 0.95) !important;">
        <div class="row align-items-center justify-content-center g-3">
            
            {{-- Icône et titre --}}
            <div class="col-md-auto">
                <div class="d-flex align-items-center">
                    <i class="fas fa-filter text-primary me-2 fs-5"></i>
                    <span class="fw-semibold text-dark">Filtrer par :</span>
                </div>
            </div>

            {{-- Filtre : Matière --}}
            @if($matières->count())
                <div class="col-md-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle fw-semibold px-4 py-2 rounded-pill border-2" 
                                type="button" id="matiereDropdown" data-bs-toggle="dropdown"
                                style="min-width: 160px; transition: all 0.3s ease;">
                            <i class="fas fa-book me-2"></i>
                            @if(request('matiere_id'))
                                {{ $matières->where('id_Matiere', request('matiere_id'))->first()->Nom ?? 'Matière' }}
                            @else
                                Matière
                            @endif
                        </button>
                        <ul class="dropdown-menu shadow-lg border-0 rounded-3" aria-labelledby="matiereDropdown" style="min-width: 200px;">
                            <li><h6 class="dropdown-header text-primary fw-bold">Choisir une matière</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach($matières as $matiere)
                                <li>
                                    <a class="dropdown-item py-2 rounded-2 {{ request('matiere_id') == $matiere->id_Matiere ? 'active bg-primary text-white' : '' }}"
                                       href="{{ route('etudiant.dashboard', ['matiere_id' => $matiere->id_Matiere]) }}"
                                       style="margin: 2px 8px; transition: all 0.2s ease;">
                                        <i class="fas fa-bookmark me-2"></i>
                                        {{ $matiere->Nom }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Filtre : Type de support --}}
            @if(request('matiere_id'))
                <div class="col-md-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle fw-semibold px-4 py-2 rounded-pill border-2" 
                                type="button" id="typeDropdown" data-bs-toggle="dropdown"
                                style="min-width: 180px; transition: all 0.3s ease;">
                            <i class="fas fa-file-alt me-2"></i>
                            @if(request('type_id'))
                                {{ $types->where('id_type', request('type_id'))->first()->nom ?? 'Type de support' }}
                            @else
                                Type de support
                            @endif
                        </button>
                        <ul class="dropdown-menu shadow-lg border-0 rounded-3" aria-labelledby="typeDropdown" style="min-width: 220px;">
                            <li><h6 class="dropdown-header text-secondary fw-bold">Type de contenu</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach($types as $type)
                                <li>
                                    <a class="dropdown-item py-2 rounded-2 {{ request('type_id') == $type->id_type ? 'active bg-secondary text-white' : '' }}"
                                       href="{{ route('etudiant.dashboard', [
                                           'matiere_id' => request('matiere_id'),
                                           'type_id' => $type->id_type
                                       ]) }}"
                                       style="margin: 2px 8px; transition: all 0.2s ease;">
                                        <i class="fas fa-tag me-2"></i>
                                        {{ $type->nom }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Bouton reset --}}
            @if(request('matiere_id') || request('type_id'))
                <div class="col-md-auto">
                    <a href="{{ route('etudiant.dashboard') }}" class="btn btn-outline-danger rounded-pill px-3 py-2" title="Réinitialiser les filtres">
                        <i class="fas fa-times me-1"></i>
                        Reset
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Instructions ou affichage des supports --}}
@if(!request('matiere_id') || !request('type_id'))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="instruction-card text-center p-5 rounded-4 shadow-lg border-0" 
                     style="background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%); border-left: 6px solid #667eea !important;">
                    
                    <div class="mb-4">
                        <i class="fas fa-graduation-cap text-primary" style="font-size: 4rem; opacity: 0.8;"></i>
                    </div>
                    
                    <h3 class="text-dark fw-bold mb-4">Comment accéder à vos supports ?</h3>
                    
                    <div class="steps-container">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="step-card bg-white p-4 rounded-3 shadow-sm h-100 border-0" style="border-left: 4px solid #667eea !important;">
                                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 40px; height: 40px; font-weight: bold;">1</div>
                                    <h5 class="fw-bold text-dark mb-2">Choisir une matière</h5>
                                    <p class="text-muted mb-0">Sélectionnez la matière qui vous intéresse</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="step-card bg-white p-4 rounded-3 shadow-sm h-100 border-0" style="border-left: 4px solid #28a745 !important;">
                                    <div class="step-number bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 40px; height: 40px; font-weight: bold;">2</div>
                                    <h5 class="fw-bold text-dark mb-2">Type de support</h5>
                                    <p class="text-muted mb-0">Choisissez le format souhaité</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Utilisez les filtres ci-dessus pour commencer
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container">
        {{-- Statistiques rapides --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="stats-card bg-white rounded-3 shadow-sm p-3 border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-bar text-primary me-3 fs-5"></i>
                            <span class="fw-semibold text-dark">
                                {{ $supports->count() }} support(s) trouvé(s)
                                @if(request('matiere_id'))
                                    pour <span class="text-primary">{{ $matières->where('id_Matiere', request('matiere_id'))->first()->Nom ?? 'cette matière' }}</span>
                                @endif
                            </span>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Mis à jour récemment
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Liste des supports --}}
        <div class="row g-4">
            @forelse($supports as $support)
                <div class="col-lg-4 col-md-6">
                    <div class="support-card card h-100 border shadow-sm rounded-3 position-relative" 
                         style="transition: all 0.3s ease; border-color: #e2e8f0 !important;">

                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <h5 class="card-title fw-bold mb-0 text-dark" style="line-height: 1.3;">
                                    {{ $support->titre }}
                                </h5>
                                
                                @php 
                                    $format = strtolower($support->format);
                                    $iconClass = 'fas fa-file';
                                    
                                    if(strpos($format, 'pdf') !== false) {
                                        $iconClass = 'fas fa-file-pdf';
                                    } elseif(strpos($format, 'ppt') !== false) {
                                        $iconClass = 'fas fa-file-powerpoint';
                                    } elseif(strpos($format, 'word') !== false || strpos($format, 'doc') !== false) {
                                        $iconClass = 'fas fa-file-word';
                                    } elseif(strpos($format, 'video') !== false) {
                                        $iconClass = 'fas fa-play-circle';
                                    }
                                @endphp
                                
                                <i class="{{ $iconClass }} text-muted fs-5"></i>
                            </div>
                            
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    <i class="fas fa-bookmark me-1 text-muted"></i>
                                    {{ $support->matiere->Nom ?? 'Matière inconnue' }}
                                </span>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    {{-- Bouton principal --}}
                                    @if(strpos($format, 'pdf') !== false)
                                        <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                                           class="btn btn-outline-dark fw-semibold py-2 rounded-3" target="_blank">
                                            <i class="fas fa-file-pdf me-2"></i>Voir le PDF
                                        </a>
                                    @elseif(strpos($format, 'ppt') !== false)
                                        <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                                           class="btn btn-outline-dark fw-semibold py-2 rounded-3">
                                            <i class="fas fa-download me-2"></i>Télécharger PPT
                                        </a>
                                    @elseif(strpos($format, 'word') !== false || strpos($format, 'doc') !== false)
                                        <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                                           class="btn btn-outline-dark fw-semibold py-2 rounded-3">
                                            <i class="fas fa-download me-2"></i>Télécharger Word
                                        </a>
                                    @elseif(strpos($format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                        <a href="{{ route('etudiant.supports.consultation', ['id_support' => $support->id_support]) }}" 
                                           class="btn btn-outline-dark fw-semibold py-2 rounded-3">
                                            <i class="fas fa-play me-2"></i>Regarder la vidéo
                                        </a>
                                    @endif

                                    {{-- Bouton traduction --}}
                                    <a href="{{ route('etudiant.supports.showTranslateForm', ['id' => $support->id_support]) }}" 
                                       class="btn btn-outline-secondary fw-semibold py-2 rounded-3" title="Traduire ce support">
                                        <i class="fas fa-language me-2"></i>Traduire
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="empty-state p-5 rounded-4" style="background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);">
                            <i class="fas fa-search text-muted mb-4" style="font-size: 3rem; opacity: 0.5;"></i>
                            <h4 class="text-muted fw-bold mb-3">Aucun support trouvé</h4>
                            <p class="text-muted mb-4">Essayez de modifier vos critères de recherche ou contactez votre enseignant.</p>
                            <a href="{{ route('etudiant.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-2"></i>Retour aux filtres
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination modernisée --}}
        @if($supports instanceof \Illuminate\Pagination\LengthAwarePaginator && $supports->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Navigation des supports">
                    {{ $supports->withQueryString()->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        @endif
    </div>
@endif

@endsection

{{-- Scripts Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Styles personnalisés --}}
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-light: 0 2px 15px rgba(0, 0, 0, 0.08);
        --shadow-medium: 0 5px 25px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
    }

    body {
        background: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Cards avec effet hover */
    .support-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-medium) !important;
    }

    .filter-card:hover {
        box-shadow: var(--shadow-medium) !important;
    }

    /* Boutons avec animations */
    .btn {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-outline-primary:hover,
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Dropdowns améliorés */
    .dropdown-menu {
        border: none !important;
        box-shadow: var(--shadow-medium) !important;
        margin-top: 8px !important;
    }

    .dropdown-item:hover {
        background: rgba(102, 126, 234, 0.1) !important;
        color: #667eea !important;
    }

    .dropdown-item.active {
        background: #667eea !important;
    }

    /* Pagination personnalisée */
    .pagination {
        gap: 8px;
    }

    .pagination .page-link {
        border: 2px solid #e2e8f0;
        color: #64748b;
        border-radius: 8px;
        font-weight: 500;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
        transform: translateY(-1px);
    }

    .pagination .page-item.active .page-link {
        background: #667eea;
        border-color: #667eea;
    }

    /* Responsive amélioré */
    @media (max-width: 768px) {
        .filter-card .row {
            text-align: center;
        }
        
        .filter-card .col-md-auto {
            margin-bottom: 8px;
        }
        
        .dropdown .btn {
            width: 100%;
            min-width: auto !important;
        }
        
        .hero-section {
            padding: 2rem 0 !important;
        }
        
        .hero-section .display-4 {
            font-size: 2rem !important;
        }
        
        .support-card {
            margin-bottom: 1rem;
        }
    }

    /* Animations d'entrée */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .support-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .support-card:nth-child(2) { animation-delay: 0.1s; }
    .support-card:nth-child(3) { animation-delay: 0.2s; }
    .support-card:nth-child(4) { animation-delay: 0.3s; }

    /* États de focus améliorés */
    .btn:focus,
    .dropdown-toggle:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25) !important;
    }

    /* Indicateurs visuels */
    .step-number {
        font-size: 1.1rem;
    }

    .stats-card {
        border-left: 4px solid #667eea !important;
    }

    /* Performance */
    * {
        -webkit-tap-highlight-color: transparent;
    }
</style>