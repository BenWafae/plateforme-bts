@extends('layouts.professeur')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Configuration des couleurs personnalisées */
        .bg-violet-custom {
            background-color: #5E60CE;
        }
        .text-violet-custom {
            color: #5E60CE;
        }
        .border-violet-custom {
            border-color: #5E60CE;
        }
        .bg-violet-50 {
            background-color: rgba(94, 96, 206, 0.05);
        }
        .bg-violet-100 {
            background-color: rgba(94, 96, 206, 0.1);
        }
        .hover\:bg-violet-700:hover {
            background-color: #4F50AD;
        }
        .hover\:text-violet-700:hover {
            color: #4F50AD;
        }
        .from-violet-custom {
            --tw-gradient-from: #5E60CE;
            --tw-gradient-to: rgba(94, 96, 206, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-violet-custom {
            --tw-gradient-to: #5E60CE;
        }

        /* Animation pour les cartes */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Animation pour les éléments de liste */
        .list-item-hover {
            transition: all 0.2s ease;
        }
        .list-item-hover:hover {
            background-color: rgba(94, 96, 206, 0.02);
            border-left: 4px solid #5E60CE;
            padding-left: 1.5rem;
        }

        /* Effet de brillance pour les icônes */
        .icon-shine {
            transition: all 0.3s ease;
        }
        .icon-shine:hover {
            transform: scale(1.1);
            filter: brightness(1.2);
        }

        /* Animation pour les statistiques */
        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        /* Animation de chargement */
        .pulse-custom {
            animation: pulse-custom 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse-custom {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .7;
            }
        }

        /* Style pour les filtres */
        .filter-container {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
        }

        /* Style personnalisé pour le graphique */
        .chart-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
        }

        /* Style pour les badges */
        .badge-gradient {
            background: linear-gradient(135deg, #5E60CE 0%, #7C3AED 100%);
        }

        /* Style personnalisé pour la pagination */
        .pagination-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-custom .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffff;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .pagination-custom .page-link:hover {
            background-color: #5E60CE;
            color: #ffffff;
            border-color: #5E60CE;
        }

        .pagination-custom .page-link.active {
            background-color: #5E60CE;
            color: #ffffff;
            border-color: #5E60CE;
        }

        .pagination-custom .page-link.disabled {
            color: #9ca3af;
            background-color: #f9fafb;
            cursor: not-allowed;
        }

        .pagination-custom .page-link.disabled:hover {
            background-color: #f9fafb;
            color: #9ca3af;
            border-color: #e5e7eb;
        }
    </style>
@endsection

@section('breadcrumb', 'Statistiques des consultations')

@section('content')
<div class="p-6 lg:p-8">
    <!-- En-tête de la page -->
    <div class="text-center mb-12">
        <div class="bg-gradient-to-br from-violet-custom to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-12 sm:px-12 sm:py-16 text-center text-white">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white bg-opacity-20 mb-6">
                    <i class="fas fa-chart-bar text-3xl"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4">
                    Analyse des consultations
                </h1>
                <p class="text-lg md:text-xl opacity-90 max-w-3xl mx-auto">
                    Suivez l'utilisation de vos supports éducatifs et analysez les tendances de consultation par type et par semaine.
                </p>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @php
            $totalConsultations = collect($statistiques)->sum(function($supports) {
                return $supports->sum('consultations_count');
            });
            $totalSupports = collect($statistiques)->sum(function($supports) {
                return $supports->count();
            });
            $typesPlusConsultes = collect($statistiques)->sortByDesc(function($supports) {
                return $supports->sum('consultations_count');
            })->keys()->first();
        @endphp

        <!-- Total consultations -->
        <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-eye text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Total consultations</h3>
                            <p class="text-sm text-gray-600">Toutes périodes</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-green-600">{{ $totalConsultations }}</div>
                        <div class="text-sm text-gray-500">vues</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total supports -->
        <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-violet-custom to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-folder text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Supports actifs</h3>
                            <p class="text-sm text-gray-600">Consultables</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-violet-custom">{{ $totalSupports }}</div>
                        <div class="text-sm text-gray-500">documents</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Type le plus consulté -->
        <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-trophy text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Type populaire</h3>
                            <p class="text-sm text-gray-600">Le plus consulté</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-orange-600">{{ $typesPlusConsultes ?? 'Aucun' }}</div>
                        <div class="text-sm text-gray-500">type</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique principal -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8 overflow-hidden chart-container">
        <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-chart-line mr-3"></i>
                Évolution des consultations par type et par semaine
            </h2>
        </div>
        
        <div class="p-6">
            <div class="relative">
                <canvas id="consultationWeeklyChart" class="w-full" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8 overflow-hidden filter-container">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-filter mr-3 text-violet-custom"></i>
                Filtrer les consultations
            </h3>
        </div>
        
        <div class="p-6">
            <form method="GET" action="{{ route('consultations.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <!-- Filtre par type -->
                <div class="space-y-2">
                    <label for="type" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-tag mr-2 text-violet-custom"></i>
                        Type de support
                    </label>
                    <select name="type" id="type" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-custom focus:border-violet-custom transition-colors">
                        <option value="">Tous les types</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id_type }}" {{ $selectedType == $type->id_type ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre par matière -->
                <div class="space-y-2">
                    <label for="matiere" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-book mr-2 text-violet-custom"></i>
                        Matière
                    </label>
                    <select name="matiere" id="matiere" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-custom focus:border-violet-custom transition-colors">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_Matiere }}" {{ $selectedMatiere == $matiere->id_Matiere ? 'selected' : '' }}>
                                {{ $matiere->Nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton de filtrage -->
                <div>
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-violet-custom to-indigo-600 text-white rounded-lg hover:from-violet-700 hover:to-indigo-700 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-search mr-2"></i>
                        Appliquer les filtres
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Répartition par type de support -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach($statistiques as $type => $supports)
            @php
                $totalConsultationsType = $supports->sum('consultations_count');
                $colorClasses = [
                    'bg-blue-500',
                    'bg-purple-500',
                    'bg-green-500',
                    'bg-orange-500',
                    'bg-red-500',
                    'bg-indigo-500'
                ];
                $colorClass = $colorClasses[$loop->index % count($colorClasses)];
                
                // Trier les supports par nombre de consultations (décroissant)
                $supportsTries = $supports->sortByDesc('consultations_count');
            @endphp
            
            <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-4">
                    <!-- En-tête avec type et nombre total de consultations -->
                    <div class="text-center mb-4">
                        <div class="w-12 h-12 {{ $colorClass }} rounded-full flex items-center justify-center text-white shadow-lg mx-auto mb-2">
                            <i class="fas fa-folder-open text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $type }}</h3>
                        <div class="text-2xl font-bold text-violet-custom mb-1">{{ $totalConsultationsType }}</div>
                        <p class="text-xs text-gray-600">consultations</p>
                    </div>
                    
                    <!-- Liste des supports consultés -->
                    @if($supportsTries->where('consultations_count', '>', 0)->count() > 0)
                        <div class="space-y-2">
                            <h4 class="text-xs font-semibold text-gray-700 border-b border-gray-200 pb-1">
                                Supports consultés :
                            </h4>
                            @foreach($supportsTries->where('consultations_count', '>', 0)->take(3) as $support)
                                <div class="flex items-center justify-between text-xs bg-gray-50 rounded-lg p-1.5">
                                    <span class="text-gray-700 truncate flex-1 mr-2" title="{{ $support->titre }}">
                                        {{ Str::limit($support->titre, 20) }}
                                    </span>
                                    <span class="badge-gradient text-white px-1.5 py-0.5 rounded-full text-xs font-semibold">
                                        {{ $support->consultations_count }}
                                    </span>
                                </div>
                            @endforeach
                            
                            @if($supportsTries->where('consultations_count', '>', 0)->count() > 3)
                                <div class="text-xs text-gray-500 text-center pt-1">
                                    + {{ $supportsTries->where('consultations_count', '>', 0)->count() - 3 }} autre(s)
                                </div>
                            @endif
                            
                            @if($supportsTries->where('consultations_count', '=', 0)->count() > 0)
                                <div class="text-xs text-gray-400 text-center pt-1">
                                    {{ $supportsTries->where('consultations_count', '=', 0)->count() }} non consultés
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-inbox text-gray-300 text-lg mb-1"></i>
                            <p class="text-xs text-gray-500">Aucune consultation</p>
                            @if($supports->count() > 0)
                                <p class="text-xs text-gray-400">{{ $supports->count() }} support(s) disponible(s)</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Liste des consultations -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center justify-between">
                <span class="flex items-center">
                    <i class="fas fa-history mr-3"></i>
                    Dernières consultations
                </span>
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold text-white">
                    {{ $consultations->total() }} au total
                </span>
            </h2>
        </div>
        
        <div class="p-6">
            @forelse($consultations as $consultation)
                <div class="list-item-hover flex flex-col lg:flex-row lg:items-center lg:justify-between p-4 rounded-xl border border-gray-100 mb-4 bg-gray-50">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar utilisateur -->
                        <div class="w-12 h-12 bg-gradient-to-br from-violet-custom to-indigo-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ strtoupper(substr($consultation->user->prenom, 0, 1)) }}{{ strtoupper(substr($consultation->user->nom, 0, 1)) }}
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $consultation->user->prenom }} {{ $consultation->user->nom }}
                                </h3>
                                <span class="badge-gradient text-white px-2 py-1 rounded-full text-xs">
                                    Étudiant
                                </span>
                            </div>
                            
                            <p class="text-gray-700 mb-2">
                                a consulté 
                                <span class="font-semibold text-violet-custom">"{{ $consultation->support->titre }}"</span>
                            </p>
                            
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <span class="inline-flex items-center">
                                    <i class="fas fa-tag mr-1 text-violet-custom"></i>
                                    {{ $consultation->support->type->nom }}
                                </span>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-book mr-1 text-violet-custom"></i>
                                    {{ $consultation->support->matiere->Nom ?? 'Matière non spécifiée' }}
                                </span>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-clock mr-1 text-violet-custom"></i>
                                    {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-violet-custom text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucune consultation</h3>
                    <p class="text-gray-600 mb-6">Aucune consultation n'a été enregistrée avec les filtres actuels.</p>
                    <a href="{{ route('consultations.index') }}" class="inline-flex items-center px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>
                        Réinitialiser les filtres
                    </a>
                </div>
            @endforelse

            <!-- Pagination personnalisée -->
            @if($consultations->hasPages())
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Informations de pagination -->
                        <div class="text-sm text-gray-600">
                            Affichage de <span class="font-semibold">{{ $consultations->firstItem() }}</span> à 
                            <span class="font-semibold">{{ $consultations->lastItem() }}</span> 
                            sur <span class="font-semibold">{{ $consultations->total() }}</span> consultations
                        </div>
                        
                        <!-- Navigation pagination -->
                        <div class="pagination-custom">
                            {{-- Previous Page Link --}}
                            @if ($consultations->onFirstPage())
                                <span class="page-link disabled">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $consultations->previousPageUrl() }}" class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($consultations->getUrlRange(1, $consultations->lastPage()) as $page => $url)
                                @if ($page == $consultations->currentPage())
                                    <span class="page-link active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($consultations->hasMorePages())
                                <a href="{{ $consultations->nextPageUrl() }}" class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="page-link disabled">
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('consultationWeeklyChart').getContext('2d');

        const labels = @json(array_keys($consultationsParSemaine)); // Types de support
        const semaines = @json(
            collect($consultationsParSemaine)
                ->flatten(2)
                ->pluck('date_consultation')
                ->map(fn($d) => \Carbon\Carbon::parse($d)->startOfWeek()->format('Y-m-d'))
                ->unique()
                ->sort()
                ->values()
                ->toArray()
        );

        const rawData = @json($consultationsParSemaine);

        // Palette de couleurs harmonieuse
        const colors = [
            '#5E60CE', // Violet principal
            '#7C3AED', // Violet plus foncé
            '#10B981', // Vert emerald
            '#F59E0B', // Orange amber
            '#EF4444', // Rouge
            '#8B5CF6', // Violet purple
            '#06B6D4', // Cyan
            '#84CC16', // Lime
        ];

        const datasets = semaines.map((semaine, index) => {
            return {
                label: 'Semaine du ' + new Date(semaine).toLocaleDateString('fr-FR'),
                data: labels.map(type => {
                    const consultations = rawData[type]?.[semaine] ?? [];
                    return consultations.length;
                }),
                backgroundColor: colors[index % colors.length],
                borderColor: colors[index % colors.length],
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            };
        });

        const config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Consultations par type de support et par semaine',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        color: '#374151'
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#5E60CE',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            title: function(context) {
                                const typeSupport = context[0].label;
                                return 'Type : ' + typeSupport;
                            },
                            label: function(context) {
                                const semaineLabel = context.dataset.label;
                                const count = context.raw;
                                return `${semaineLabel} - ${count} consultation${count > 1 ? 's' : ''}`;
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    x: { 
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#6B7280'
                        }
                    },
                    y: { 
                        stacked: true, 
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#6B7280'
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        };

        new Chart(ctx, config);
    });
</script>
@endsection