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

                        <div class="text-2xl font-bold text-purple-800">{{ $consultations->total() }}</div>
<div class="text-sm text-gray-700">Total consultations</div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- Graphiques stylisés -->

    <div class="charts-section mb-6">

        <!-- Graphique par matière -->

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">

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



        <!-- Nouveau graphique par semaine -->

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-green-50 to-blue-50 px-6 py-4 border-b border-gray-100">

                <h3 class="text-xl font-semibold text-gray-800 flex items-center">

                    <i class="fas fa-chart-line text-green-600 mr-3"></i>

                    Évolution des Consultations par Semaine

                </h3>

                <p class="text-gray-600 text-sm mt-1">Tendance des consultations au fil du temps par matière</p>

            </div>

            <div class="p-6">

                <div class="chart-container" style="position: relative; height: 450px;">

                    <canvas id="graphConsultationsParSemaine"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- section avant recommendation --}}

  <!-- Section Insights Étudiants - À ajouter avant la section recommandations -->
<div class="insights-section mb-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-users text-cyan-600 mr-3"></i>
                Centres d'Intérêt des Étudiants
            </h3>
            <p class="text-gray-600 text-sm mt-1">Comprendre les préférences d'apprentissage</p>
        </div>
        
        <div class="p-6">
            @php
                // Récupérer les matières les plus consultées
                $top3Matieres = $consultationsParMatiere->sortDesc()->take(3);
                $matiereTop1 = $top3Matieres->keys()->first();
                $matiereTop2 = $top3Matieres->keys()->skip(1)->first();
                $matiereTop3 = $top3Matieres->keys()->skip(2)->first();
            @endphp
            
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl p-6 text-white">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-2xl text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold mb-3">Les étudiants sont intéressés par :</h4>
                        <div class="flex flex-wrap gap-3">
                            @if($matiereTop1)
                                <span class="bg-blue-600 px-4 py-2 rounded-full text-sm font-bold text-white">
                                    🥇 {{ $matiereTop1 }}
                                </span>
                            @endif
                            @if($matiereTop2)
                                <span class="bg-green-600 px-4 py-2 rounded-full text-sm font-bold text-white">
                                    🥈 {{ $matiereTop2 }}
                                </span>
                            @endif
                            @if($matiereTop3)
                                <span class="bg-purple-600 px-4 py-2 rounded-full text-sm font-bold text-white">
                                    🥉 {{ $matiereTop3 }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






    {{-- recommandations --}}

    <!-- Section Recommandations - À ajouter après la section des graphiques -->
<div class="recommendations-section mb-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-lightbulb text-amber-600 mr-3"></i>
                Recommandations de Publication
            </h3>
            <p class="text-gray-600 text-sm mt-1">Suggestions basées sur l'analyse des consultations</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Recommandation 1: Matière la plus consultée -->
                @php
                    $matierePopulaire = $consultationsParMatiere->sortDesc()->first();
                    $nomMatierePopulaire = $consultationsParMatiere->sortDesc()->keys()->first();
                    $pourcentage = $consultationsParMatiere->sum() > 0 ? round(($matierePopulaire / $consultationsParMatiere->sum()) * 100, 1) : 0;
                @endphp
                
                <div class="recommendation-card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-trophy text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-star text-amber-500 mr-2"></i>
                                Matière Prioritaire
                            </h4>
                            <p class="text-gray-700 text-sm mb-3">
                                <span class="font-semibold text-green-700">{{ $nomMatierePopulaire }}</span> 
                                représente <span class="font-bold text-green-600">{{ $pourcentage }}%</span> des consultations
                            </p>
                            <div class="bg-white rounded-lg p-3 border border-green-100">
                                <p class="text-xs text-gray-600 font-medium">
                                    💡 <strong>Recommandation:</strong> Publiez plus de contenus en {{ $nomMatierePopulaire }} 
                                    ({{ $matierePopulaire }} consultations)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommandation 2: Matière sous-exploitée -->
                @php
                    $matiereMoinsConsultee = $consultationsParMatiere->filter(function($value) { 
                        return $value > 0; 
                    })->sortBy(function($value) { 
                        return $value; 
                    })->first();
                    $nomMatiereMoinsConsultee = $consultationsParMatiere->filter(function($value) { 
                        return $value > 0; 
                    })->sortBy(function($value) { 
                        return $value; 
                    })->keys()->first();
                @endphp
                
                <div class="recommendation-card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-chart-line text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-arrow-up text-blue-500 mr-2"></i>
                                Potentiel à Développer
                            </h4>
                            <p class="text-gray-700 text-sm mb-3">
                                <span class="font-semibold text-blue-700">{{ $nomMatiereMoinsConsultee }}</span> 
                                a seulement <span class="font-bold text-blue-600">{{ $matiereMoinsConsultee }}</span> consultation(s)
                            </p>
                            <div class="bg-white rounded-lg p-3 border border-blue-100">
                                <p class="text-xs text-gray-600 font-medium">
                                    🚀 <strong>Opportunité:</strong> Créez des contenus attractifs en {{ $nomMatiereMoinsConsultee }} 
                                    pour stimuler l'engagement
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Statistique globale -->
            <div class="mt-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-4 border border-purple-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Performance Globale</p>
                            <p class="text-xs text-gray-600">{{ $consultationsParMatiere->count() }} matières actives</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-purple-600">{{ $consultationsParMatiere->sum() }}</p>
                        <p class="text-xs text-purple-500 font-medium">Total consultations</p>
                    </div>
                         <div class="text-right">
                        <p class="text-lg font-bold text-indigo-600">{{ number_format($consultationsParMatiere->avg(), 1) }}</p>
                        <p class="text-xs text-indigo-500 font-medium">Moyenne/matière</p>
                    </div>
                </div>
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

                        <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
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

    // Graphique par matière (graphique en barres)

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



    // Nouveau graphique par semaine (graphique linéaire)

    const ctxSemaine = document.getElementById('graphConsultationsParSemaine')?.getContext('2d');



    if (ctxSemaine) {

        const consultationsParSemaine = {!! json_encode($consultationsParMatiereParSemaine) !!};

        

        // Récupérer toutes les semaines uniques et les trier

        const toutesLesSemaines = new Set();

        Object.values(consultationsParSemaine).forEach(semaineData => {

            Object.keys(semaineData).forEach(semaine => toutesLesSemaines.add(semaine));

        });

        const semainesTriees = Array.from(toutesLesSemaines).sort();



        // Couleurs pour chaque matière

        const couleurs = [

            { bg: 'rgba(34, 197, 94, 0.3)', border: 'rgba(34, 197, 94, 1)' },

            { bg: 'rgba(59, 130, 246, 0.3)', border: 'rgba(59, 130, 246, 1)' },

            { bg: 'rgba(239, 68, 68, 0.3)', border: 'rgba(239, 68, 68, 1)' },

            { bg: 'rgba(245, 158, 11, 0.3)', border: 'rgba(245, 158, 11, 1)' },

            { bg: 'rgba(168, 85, 247, 0.3)', border: 'rgba(168, 85, 247, 1)' },

            { bg: 'rgba(236, 72, 153, 0.3)', border: 'rgba(236, 72, 153, 1)' },

        ];



        // Créer les datasets pour chaque matière

        const datasets = Object.keys(consultationsParSemaine).map((matiere, index) => {

            const data = semainesTriees.map(semaine => 

                consultationsParSemaine[matiere][semaine] || 0

            );

            

            const couleur = couleurs[index % couleurs.length];

            

            return {

                label: matiere,

                data: data,

                backgroundColor: couleur.bg,

                borderColor: couleur.border,

                borderWidth: 3,

                fill: true,

                tension: 0.4,

                pointBackgroundColor: couleur.border,

                pointBorderColor: '#fff',

                pointBorderWidth: 2,

                pointRadius: 5,

                pointHoverRadius: 7,

            };

        });



        // Formater les labels des semaines pour l'affichage

        const semainesFormatees = semainesTriees.map(semaine => {

            const date = new Date(semaine);

            return date.toLocaleDateString('fr-FR', { 

                day: '2-digit', 

                month: '2-digit',

                year: '2-digit'

            });

        });



        const semaineData = {

            labels: semainesFormatees,

            datasets: datasets

        };



        const semaineOptions = {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: true,

                    position: 'top',

                    labels: {

                        usePointStyle: true,

                        padding: 20,

                        font: {

                            size: 12,

                            weight: 'bold'

                        }

                    }

                },

                tooltip: {

                    mode: 'index',

                    intersect: false,

                    backgroundColor: 'rgba(0, 0, 0, 0.8)',

                    titleColor: '#fff',

                    bodyColor: '#fff',

                    borderColor: 'rgba(34, 197, 94, 1)',

                    borderWidth: 1,

                    cornerRadius: 8,

                    callbacks: {

                        title: function(context) {

                            return 'Semaine du ' + context[0].label;

                        },

                        label: function(context) {

                            return context.dataset.label + ': ' + context.raw + ' consultation(s)';

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

                            size: 10

                        },

                        maxRotation: 45

                    },

                    grid: {

                        color: 'rgba(107, 114, 128, 0.1)',

                        drawBorder: false,

                    }

                }

            },

            interaction: {

                mode: 'index',

                intersect: false,

            },

            animation: {

                duration: 1500,

                easing: 'easeInOutQuart'

            }

        };



        new Chart(ctxSemaine, {

            type: 'line',

            data: semaineData,

            options: semaineOptions

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