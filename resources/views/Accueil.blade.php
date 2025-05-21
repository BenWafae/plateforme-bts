@extends('layouts.cours_public')

@section('content')
<div class="container-fluid px-4 py-4">
    @if(request()->has('matiere_id'))
    <!-- Affichage des supports avec les boutons fonctionnels -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($supports as $support)
        <div class="col">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="card-body">
                    <h5 class="card-title">{{ $support->titre }}</h5>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-secondary">{{ strtoupper($support->format) }}</span>
                        <small class="text-muted">{{ round($support->taille / 1024) }} KB</small>
                    </div>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-book me-1"></i> {{ $matieres->firstWhere('id_Matiere', request('matiere_id'))->Nom }}
                    </p>
                    <p class="text-muted small">
                        <i class="far fa-calendar me-1"></i> {{ $support->created_at->format('d/m/Y') }}
                    </p>
                </div>

                @if($support->format === 'pdf')
                    <a href="{{ route('fichiers.view', $support->id_support) }}" class="btn btn-outline-danger w-100" target="_blank" rel="noopener">
                        <i class="fas fa-file-pdf me-1"></i> Voir PDF
                    </a>
                  @elseif(strpos($support->format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                                        <a href="{{ $support->lien_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fab fa-youtube"></i> Regarder
                                        </a>
                @elseif(in_array($support->format, ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'zip']))
                    <a href="{{ route('fichiers.download', $support->id_support) }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-download me-1"></i> Télécharger
                    </a>
                @else
                    <a href="{{ route('fichiers.download', $support->id_support) }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-download me-1"></i> Télécharger
                    </a>
                @endif

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center py-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                Aucun {{ request('type') }} disponible pour cette matière
            </div>
        </div>
        @endforelse
    </div>

    @elseif(request()->has('type'))
    <!-- Filtres de sélection - affichage horizontal progressif -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-4">
                <i class="fas fa-filter me-2"></i> Navigation des ressources :
                <span class="badge bg-primary">{{ ucfirst(request('type')) }}</span>
            </h2>

            <div class="d-flex flex-wrap align-items-start gap-3 flex-lg-nowrap flex-wrap">
                <!-- Étape 1 : Années -->
                <div>
                    <h6 class="mb-2">Année</h6>
                    <div class="btn-group-vertical">
                        <a href="?type={{ request('type') }}&annee=1"
                           class="btn {{ request('annee') == 1 ? 'btn-primary' : 'btn-outline-primary' }}">
                            1ère année
                        </a>
                        <a href="?type={{ request('type') }}&annee=2"
                           class="btn {{ request('annee') == 2 ? 'btn-primary' : 'btn-outline-primary' }}">
                            2ème année
                        </a>
                    </div>
                </div>

                <!-- Étape 2 : Filières -->
                @if(request()->has('annee'))
                <div>
                    <h6 class="mb-2">Filière</h6>
                    <div class="btn-group-vertical">
                        @foreach($filieres as $filiere)
                        <a href="?type={{ request('type') }}&annee={{ request('annee') }}&filiere_id={{ $filiere->id_filiere }}"
                           class="btn {{ request('filiere_id') == $filiere->id_filiere ? 'btn-info' : 'btn-outline-info' }}">
                            {{ $filiere->nom_filiere }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Étape 3 : Matières -->
                @if(request()->has('filiere_id'))
                <div>
                    <h6 class="mb-2">Matière</h6>
                    <div class="btn-group-vertical">
                        @foreach($matieres->where('id_filiere', request('filiere_id')) as $matiere)
                        <a href="?type={{ request('type') }}&annee={{ request('annee') }}&filiere_id={{ request('filiere_id') }}&matiere_id={{ $matiere->id_Matiere }}"
                           class="btn {{ request('matiere_id') == $matiere->id_Matiere ? 'btn-warning' : 'btn-outline-warning' }}">
                            {{ $matiere->Nom }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Message guide -->
    @unless(request()->has('matiere_id'))
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas {{ request()->has('filiere_id') ? 'fa-book' : 'fa-search' }} fa-3x text-muted mb-4"></i>
            <h4 class="mb-3">
                @if(request()->has('filiere_id'))
                Sélectionnez une matière
                @elseif(request()->has('annee'))
                Sélectionnez une filière
                @else
                Sélectionnez une année académique
                @endif
            </h4>
            <p class="text-muted mb-0">Utilisez les filtres ci-dessus pour afficher les ressources</p>
        </div>
    </div>
    @endunless

    @else
    <!-- Page d'accueil -->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-graduation-cap fa-4x text-primary mb-4"></i>
                    <h1 class="h3 mb-3">Bienvenue sur la plateforme BTS AI Idrissi</h1>
                    <p class="lead text-muted mb-4">Sélectionnez un type de ressource pour commencer</p>
                    
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="?type=cours" class="btn btn-primary px-4">
                            <i class="fas fa-book-open me-2"></i>Cours
                        </a>
                        <a href="?type=td" class="btn btn-outline-primary px-4">
                            <i class="fas fa-tasks me-2"></i>exercices
                        </a>
                        <a href="?type=examens" class="btn btn-outline-primary px-4">
                            <i class="fas fa-file-alt me-2"></i>Examens
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
