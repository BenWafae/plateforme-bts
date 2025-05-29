@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <!-- En-tête avec titre stylisé -->
    <div class="header-section mb-5">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">
                        <i class="fas fa-chart-line mr-3"></i>
                        Statistiques des Consultations
                    </h1>
                    <p class="text-purple-100">Analysez l'engagement des étudiants avec vos contenus</p>
                </div>
                <div class="text-right">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <div class="text-2xl font-bold">{{ $consultations->total() }}</div>
                        <div class="text-sm text-purple-100">Total consultations</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique stylisé -->
    <div class="chart-section mb-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar text-purple-600 mr-3"></i>
                    Consultations par Matière
                </h3>
                <p class="text-gray-600 text-sm mt-1">Distribution des consultations selon les matières</p>
            </div>
            <div class="p-6">
                <div class="chart-container" style="position: relative; height: 400px;">
                    <canvas id="graphConsultationsParMatiere"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de filtrage stylisée -->
    <div class="filter-section mb-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-filter text-purple-600 mr-3"></i>
                    Filtres de Recherche
                </h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.consultations') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <!-- Filtrage par matière -->
                    <div class="form-group">
                        <label for="matiere" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-book text-purple-500 mr-2"></i>
                            Matière
                        </label>
                        <select name="matiere" id="matiere" class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id_Matiere }}" {{ request('matiere') == $matiere->id_Matiere ? 'selected' : '' }}>
                                    {{ $matiere->Nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtrage par type -->
                    <div class="form-group">
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag text-purple-500 mr-2"></i>
                            Type de Support
                        </label>
                        <select name="type" id="type" class="form-select w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                            <option value="">Tous les types</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id_type }}" {{ request('type') == $type->id_type ? 'selected' : '' }}>
                                    {{ $type->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-group flex gap-3">
                        <button type="submit" class="btn-primary flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg font-semibold">
                            <i class="fas fa-search mr-2"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.consultations') }}" class="btn-secondary flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-all font-semibold text-center">
                            <i class="fas fa-refresh mr-2"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des consultations avec meilleur styling -->
    <div class="consultations-section">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-history mr-3"></i>
                        Consultations Récentes
                    </h2>
                    <div class="flex items-center gap-4">
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $consultations->total() }} au total
                        </span>
                        <div class="text-sm opacity-90">
                            <i class="fas fa-sort-amount-down mr-1"></i>
                            Du plus récent au plus ancien
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @forelse($consultations as $index => $consultation)
                    <div class="consultation-item relative flex flex-col lg:flex-row lg:items-center lg:justify-between p-5 rounded-xl border border-gray-200 mb-4 bg-gradient-to-r from-gray-50 to-purple-50 hover:from-purple-50 hover:to-indigo-50 transition-all hover:shadow-md group">
                        <!-- Numéro d'ordre -->
                        <div class="absolute -left-3 -top-3 w-8 h-8 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">
                            {{ ($consultations->currentPage() - 1) * $consultations->perPage() + $index + 1 }}
                        </div>

                        <div class="flex items-start space-x-4">
                            <!-- Avatar utilisateur -->
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr($consultation->user->prenom, 0, 1)) }}{{ strtoupper(substr($consultation->user->nom, 0, 1)) }}
                            </div>
                            
                            <div class="flex-1">
                                <!-- En-tête utilisateur -->
                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-purple-700 transition-colors">
                                        {{ $consultation->user->prenom }} {{ $consultation->user->nom }}
                                    </h3>
                                    <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                        <i class="fas fa-user-graduate mr-1"></i>
                                        Étudiant
                                    </span>
                                    <!-- Badge "Nouveau" pour les consultations récentes -->
                                    @if(\Carbon\Carbon::parse($consultation->date_consultation)->diffInHours(now()) < 24)
                                        <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-2 py-1 rounded-full text-xs font-semibold animate-pulse">
                                            <i class="fas fa-star mr-1"></i>
                                            Nouveau
                                        </span>
                                    @endif
                                </div>

                                <!-- Détails de la consultation -->
                                <div class="mb-3 p-3 bg-white rounded-lg border border-gray-100">
                                    <p class="text-gray-700 font-medium">
                                        <i class="fas fa-eye text-purple-500 mr-2"></i>
                                        a consulté 
                                        @if ($consultation->support)
                                            <span class="font-semibold text-purple-700 bg-purple-100 px-2 py-1 rounded">
                                                "{{ $consultation->support->titre }}"
                                            </span>
                                        @else
                                            <span class="text-gray-500 italic">Support inconnu</span>
                                        @endif
                                    </p>
                                </div>

                                <!-- Métadonnées -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                                    <div class="flex items-center text-gray-600 bg-white px-3 py-2 rounded-lg border border-gray-100">
                                        <i class="fas fa-tag text-purple-500 mr-2"></i>
                                        <span class="font-medium">Type:</span>
                                        <span class="ml-2 text-purple-700 font-semibold">
                                            {{ optional(optional($consultation->support)->type)->nom ?? 'Inconnu' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center text-gray-600 bg-white px-3 py-2 rounded-lg border border-gray-100">
                                        <i class="fas fa-book text-purple-500 mr-2"></i>
                                        <span class="font-medium">Matière:</span>
                                        <span class="ml-2 text-purple-700 font-semibold">
                                            {{ $consultation->support->matiere->Nom ?? 'Non spécifiée' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center text-gray-600 bg-white px-3 py-2 rounded-lg border border-gray-100">
                                        <i class="fas fa-clock text-purple-500 mr-2"></i>
                                        <span class="font-medium">Date:</span>
                                        <span class="ml-2 text-purple-700 font-semibold">
                                            {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y à H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- État vide stylisé -->
                    <div class="empty-state text-center py-16">
                        <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-chart-line text-purple-400 text-5xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucune consultation trouvée</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Aucune consultation n'a été enregistrée avec les filtres actuels. 
                            Essayez de modifier vos critères de recherche.
                        </p>
                        <a href="{{ route('admin.consultations') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl font-semibold">
                            <i class="fas fa-refresh mr-3"></i>
                            Réinitialiser les filtres
                        </a>
                    </div>
                @endforelse

                {{-- Pagination améliorée --}}
                @if($consultations->hasPages())
                    <div class="pagination-section mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Info affichage -->
                            <div class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                                <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                                Affichage de <span class="font-semibold text-purple-700">{{ $consultations->firstItem() }}</span> à 
                                <span class="font-semibold text-purple-700">{{ $consultations->lastItem() }}</span> 
                                sur <span class="font-semibold text-purple-700">{{ $consultations->total() }}</span> consultations
                            </div>

                            <!-- Pagination -->
                            <div class="flex items-center space-x-2">
                                {{-- Bouton page précédente --}}
                                @if ($consultations->onFirstPage())
                                    <span class="px-4 py-2 rounded-lg cursor-not-allowed bg-gray-100 text-gray-400" aria-disabled="true">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $consultations->appends(request()->query())->previousPageUrl() }}" 
                                       class="px-4 py-2 rounded-lg hover:bg-purple-600 hover:text-white transition-all bg-white border border-gray-300 text-gray-700 shadow-sm">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Nombres de pages --}}
                                @foreach ($consultations->appends(request()->query())->getUrlRange(
                                        max(1, $consultations->currentPage() - 2), 
                                        min($consultations->lastPage(), $consultations->currentPage() + 2)) as $page => $url)
                                    @if ($page == $consultations->currentPage())
                                        <span class="px-4 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 text-white cursor-default font-semibold shadow-md">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 rounded-lg hover:bg-purple-600 hover:text-white transition-all bg-white border border-gray-300 text-gray-700 shadow-sm">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Bouton page suivante --}}
                                @if ($consultations->hasMorePages())
                                    <a href="{{ $consultations->appends(request()->query())->nextPageUrl() }}" 
                                       class="px-4 py-2 rounded-lg hover:bg-purple-600 hover:text-white transition-all bg-white border border-gray-300 text-gray-700 shadow-sm">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="px-4 py-2 rounded-lg cursor-not-allowed bg-gray-100 text-gray-400" aria-disabled="true">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('graphConsultationsParMatiere')?.getContext('2d');

    if (ctx) {
        const consultationsData = {
            labels: {!! json_encode($consultationsParMatiere->keys()) !!},
            datasets: [{
                label: 'Nombre de consultations',
                data: {!! json_encode($consultationsParMatiere->values()) !!},
                backgroundColor: [
                    'rgba(147, 51, 234, 0.8)',
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(124, 58, 237, 0.8)',
                    'rgba(109, 40, 217, 0.8)',
                ],
                borderColor: [
                    'rgba(147, 51, 234, 1)',
                    'rgba(99, 102, 241, 1)',
                    'rgba(168, 85, 247, 1)',
                    'rgba(139, 92, 246, 1)',
                    'rgba(124, 58, 237, 1)',
                    'rgba(109, 40, 217, 1)',
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        };

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: false 
                },
                tooltip: { 
                    mode: 'index', 
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(147, 51, 234, 1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        title: function(context) {
                            return 'Matière: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Consultations: ' + context.raw;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        stepSize: 1,
                        color: '#6B7280',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(107, 114, 128, 0.1)',
                        drawBorder: false,
                    }
                },
                x: {
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 12
                        },
                        maxRotation: 45
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        };

        new Chart(ctx, {
            type: 'bar',
            data: consultationsData,
            options: chartOptions
        });
    }

    // Animation au scroll pour les éléments
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.consultation-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(item);
    });
</script>
@endsection
