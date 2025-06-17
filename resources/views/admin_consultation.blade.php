@extends('layouts.admin')

@section('content')

<div class="container mt-4 px-2 sm:px-4">

    <!-- En-tête avec titre stylisé -->
    <div class="header-section mb-5">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="w-full sm:w-auto">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">
                        <i class="fas fa-chart-line mr-2 sm:mr-3"></i>
                        Statistiques des Consultations
                    </h1>
                    <p class="text-purple-100 text-sm sm:text-base">Analysez l'engagement des étudiants avec vos contenus</p>
                </div>
                <div class="w-full sm:w-auto text-center sm:text-right">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3 sm:p-4">
                        <div class="text-xl sm:text-2xl font-bold text-purple-800">{{ $consultations->total() }}</div>
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
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-4 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar text-purple-600 mr-2 sm:mr-3"></i>
                    Consultations par Matière
                </h3>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Distribution des consultations selon les matières</p>
            </div>
            <div class="p-3 sm:p-6">
                <div class="chart-container" style="position: relative; height: 300px; max-height: 400px;">
                    <canvas id="graphConsultationsParMatiere"></canvas>
                </div>
            </div>
        </div>

        <!-- Nouveau graphique par semaine -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-blue-50 px-4 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-line text-green-600 mr-2 sm:mr-3"></i>
                    Évolution des Consultations par Semaine
                </h3>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Tendance des consultations au fil du temps par matière</p>
            </div>
            <div class="p-3 sm:p-6">
                <div class="chart-container" style="position: relative; height: 300px; max-height: 450px;">
                    <canvas id="graphConsultationsParSemaine"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- section avant recommendation --}}
    <!-- Section Insights Étudiants - À ajouter avant la section recommandations -->
    <div class="insights-section mb-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 px-4 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-users text-cyan-600 mr-2 sm:mr-3"></i>
                    Centres d'Intérêt des Étudiants
                </h3>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Comprendre les préférences d'apprentissage</p>
            </div>
            
            <div class="p-4 sm:p-6">
                @php
                    // Récupérer les matières les plus consultées
                    $top3Matieres = $consultationsParMatiere->sortDesc()->take(3);
                    $matiereTop1 = $top3Matieres->keys()->first();
                    $matiereTop2 = $top3Matieres->keys()->skip(1)->first();
                    $matiereTop3 = $top3Matieres->keys()->skip(2)->first();
                @endphp
                
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl p-4 sm:p-6 text-white">
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-heart text-lg sm:text-2xl text-white"></i>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h4 class="text-lg sm:text-xl font-bold mb-3">Les étudiants sont intéressés par :</h4>
                            <div class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-3 justify-center sm:justify-start">
                                @if($matiereTop1)
                                    <span class="bg-blue-600 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold text-white">
                                        🥇 {{ $matiereTop1 }}
                                    </span>
                                @endif
                                @if($matiereTop2)
                                    <span class="bg-green-600 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold text-white">
                                        🥈 {{ $matiereTop2 }}
                                    </span>
                                @endif
                                @if($matiereTop3)
                                    <span class="bg-purple-600 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold text-white">
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
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-4 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-lightbulb text-amber-600 mr-2 sm:mr-3"></i>
                    Recommandations de Publication
                </h3>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Suggestions basées sur l'analyse des consultations</p>
            </div>
            
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:gap-6">
                    
                    <!-- Recommandation 1: Matière la plus consultée -->
                    @php
                        $matierePopulaire = $consultationsParMatiere->sortDesc()->first();
                        $nomMatierePopulaire = $consultationsParMatiere->sortDesc()->keys()->first();
                        $pourcentage = $consultationsParMatiere->sum() > 0 ? round(($matierePopulaire / $consultationsParMatiere->sum()) * 100, 1) : 0;
                    @endphp
                    
                    <div class="recommendation-card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 sm:p-5">
                        <div class="flex flex-col sm:flex-row items-start space-y-3 sm:space-y-0 sm:space-x-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white flex-shrink-0 mx-auto sm:mx-0">
                                <i class="fas fa-trophy text-sm sm:text-lg"></i>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h4 class="font-bold text-gray-800 mb-2 flex items-center justify-center sm:justify-start">
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
                    
                    <div class="recommendation-card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 sm:p-5">
                        <div class="flex flex-col sm:flex-row items-start space-y-3 sm:space-y-0 sm:space-x-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white flex-shrink-0 mx-auto sm:mx-0">
                                <i class="fas fa-chart-line text-sm sm:text-lg"></i>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h4 class="font-bold text-gray-800 mb-2 flex items-center justify-center sm:justify-start">
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
                
                <!-- Statistique globale CORRIGÉE POUR MOBILE -->
                <div class="mt-4 sm:mt-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-4 border border-purple-100">
                    <!-- Version mobile (visible uniquement sur mobile) -->
                    <div class="block sm:hidden space-y-4">
                        <div class="text-center">
                            <div class="flex items-center justify-center space-x-2 mb-2">
                                <i class="fas fa-chart-bar text-purple-600 text-lg"></i>
                                <h4 class="text-sm font-medium text-gray-700">Performance Globale</h4>
                            </div>
                            <p class="text-xs text-gray-600">{{ $consultationsParMatiere->count() }} matières actives</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center bg-white rounded-lg p-3 border border-purple-100">
                                <p class="text-lg font-bold text-purple-600">{{ $consultationsParMatiere->sum() }}</p>
                                <p class="text-xs text-purple-500 font-medium">Total consultations</p>
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 border border-indigo-100">
                                <p class="text-lg font-bold text-indigo-600">{{ number_format($consultationsParMatiere->avg(), 1) }}</p>
                                <p class="text-xs text-indigo-500 font-medium">Moyenne/matière</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Version desktop (cachée sur mobile) -->
                    <div class="hidden sm:flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-bar text-purple-600 text-lg sm:text-xl"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Performance Globale</p>
                                <p class="text-xs text-gray-600">{{ $consultationsParMatiere->count() }} matières actives</p>
                            </div>
                        </div>
                        <div class="flex space-x-6 sm:space-x-8">
                            <div class="text-center">
                                <p class="text-xl sm:text-2xl font-bold text-purple-600">{{ $consultationsParMatiere->sum() }}</p>
                                <p class="text-xs text-purple-500 font-medium">Total consultations</p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-bold text-indigo-600">{{ number_format($consultationsParMatiere->avg(), 1) }}</p>
                                <p class="text-xs text-indigo-500 font-medium">Moyenne/matière</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Barre de filtrage stylisée -->
    <div class="filter-section mb-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-purple-50 px-4 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-filter text-purple-600 mr-2 sm:mr-3"></i>
                    Filtres de Recherche
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="GET" action="{{ route('admin.consultations') }}" class="grid grid-cols-1 gap-4 sm:gap-6">
                    <!-- Filtrage par matière -->
                    <div class="form-group">
                        <label for="matiere" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-book text-purple-500 mr-2"></i>
                            Matière
                        </label>
                        <select name="matiere" id="matiere" class="form-select w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm sm:text-base">
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
                        <select name="type" id="type" class="form-select w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm sm:text-base">
                            <option value="">Tous les types</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id_type }}" {{ request('type') == $type->id_type ? 'selected' : '' }}>
                                    {{ $type->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-group flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="btn-primary w-full sm:flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg font-semibold text-sm sm:text-base">
                            <i class="fas fa-search mr-2"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.consultations') }}" class="btn-secondary w-full sm:flex-1 bg-gray-100 text-gray-700 px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:bg-gray-200 transition-all font-semibold text-center text-sm sm:text-base">
                            <i class="fas fa-refresh mr-2"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Liste des consultations avec styling optimisé pour mobile -->
<div class="consultations-section">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between text-white gap-3 sm:gap-4">
                <h2 class="text-lg sm:text-xl font-bold flex items-center">
                    <i class="fas fa-history mr-2 sm:mr-3"></i>
                    Consultations Récentes
                </h2>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                    <span class="bg-gray-200 text-gray-800 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold">
                        {{ $consultations->total() }} au total
                    </span>
                    <div class="text-xs sm:text-sm opacity-90">
                        <i class="fas fa-sort-amount-down mr-1"></i>
                        Du plus récent au plus ancien
                    </div>
                </div>
            </div>
        </div>

        <div class="p-2 sm:p-6">
            @forelse($consultations as $index => $consultation)
                <div class="consultation-item relative mb-4 sm:mb-6">
                    <!-- Version Mobile (< 640px) -->
                    <div class="block sm:hidden">
                        <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl border-2 border-purple-200 p-4 shadow-lg hover:shadow-xl transition-all duration-300">
                            <!-- Header avec numéro et badges -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <!-- Numéro d'ordre -->
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">
                                        {{ ($consultations->currentPage() - 1) * $consultations->perPage() + $index + 1 }}
                                    </div>
                                    <!-- Avatar utilisateur -->
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                        {{ strtoupper(substr($consultation->user->prenom, 0, 1)) }}{{ strtoupper(substr($consultation->user->nom, 0, 1)) }}
                                    </div>
                                </div>
                                
                                <!-- Badges en haut à droite -->
                                <div class="flex flex-col items-end space-y-1">
                                    <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-sm">
                                        <i class="fas fa-user-graduate mr-1"></i>
                                        Étudiant
                                    </span>
                                    @if(\Carbon\Carbon::parse($consultation->date_consultation)->diffInHours(now()) < 24)
                                        <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-2 py-1 rounded-full text-xs font-semibold animate-pulse">
                                            <i class="fas fa-star mr-1"></i>
                                            Nouveau
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Nom de l'utilisateur -->
                            <div class="text-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800 bg-white px-4 py-2 rounded-xl border border-purple-200">
                                    {{ $consultation->user->prenom }} {{ $consultation->user->nom }}
                                </h3>
                            </div>

                            <!-- Support consulté -->
                            <div class="mb-4">
                                <div class="bg-purple-100 rounded-xl p-4 border border-purple-200">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-eye text-purple-600 mt-1 text-lg"></i>
                                        <div class="flex-1">
                                            <p class="text-sm text-purple-700 font-medium mb-1">A consulté :</p>
                                            @if ($consultation->support)
                                                <p class="font-semibold text-purple-800 break-words leading-relaxed">
                                                    "{{ $consultation->support->titre }}"
                                                </p>
                                            @else
                                                <p class="text-gray-500 italic">Support inconnu</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations détaillées en grille -->
                            <div class="space-y-3">
                                <!-- Type -->
                                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-tag text-purple-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 font-medium">TYPE</p>
                                            <p class="text-sm font-bold text-purple-700 mt-1">
                                                {{ optional(optional($consultation->support)->type)->nom ?? 'Inconnu' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Matière -->
                                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-book text-indigo-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 font-medium">MATIÈRE</p>
                                            <p class="text-sm font-bold text-indigo-700 mt-1">
                                                {{ $consultation->support->matiere->Nom ?? 'Non spécifiée' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Date -->
                                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-green-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 font-medium">DATE & HEURE</p>
                                            <p class="text-sm font-bold text-green-700 mt-1">
                                                {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}
                                            </p>
                                            <p class="text-xs text-green-600 font-medium">
                                                à {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Version Desktop (≥ 640px) - Code existant -->
                    <div class="hidden sm:block">
                        <div class="flex flex-col p-4 sm:p-5 rounded-xl border border-gray-200 bg-gradient-to-r from-gray-50 to-purple-50 hover:from-purple-50 hover:to-indigo-50 transition-all hover:shadow-md group">
                            <!-- Numéro d'ordre -->
                            <div class="absolute -left-2 -top-2 sm:-left-3 sm:-top-3 w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg">
                                {{ ($consultations->currentPage() - 1) * $consultations->perPage() + $index + 1 }}
                            </div>

                            <div class="flex flex-col sm:flex-row items-start space-y-3 sm:space-y-0 sm:space-x-4">
                                <!-- Avatar utilisateur -->
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 shadow-lg group-hover:scale-105 transition-transform mx-auto sm:mx-0">
                                    {{ strtoupper(substr($consultation->user->prenom, 0, 1)) }}{{ strtoupper(substr($consultation->user->nom, 0, 1)) }}
                                </div>
                                
                                <div class="flex-1 w-full">
                                    <!-- En-tête utilisateur -->
                                    <div class="flex flex-col sm:flex-row flex-wrap items-center gap-2 sm:gap-3 mb-3 text-center sm:text-left">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 group-hover:text-purple-700 transition-colors">
                                            {{ $consultation->user->prenom }} {{ $consultation->user->nom }}
                                        </h3>
                                        <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-2 sm:px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                            <i class="fas fa-user-graduate mr-1"></i>
                                            Étudiant
                                        </span>
                                        @if(\Carbon\Carbon::parse($consultation->date_consultation)->diffInHours(now()) < 24)
                                            <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-2 py-1 rounded-full text-xs font-semibold animate-pulse">
                                                <i class="fas fa-star mr-1"></i>
                                                Nouveau
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Détails de la consultation -->
                                    <div class="mb-3 p-3 bg-white rounded-lg border border-gray-100">
                                        <p class="text-gray-700 font-medium text-sm sm:text-base text-center sm:text-left">
                                            <i class="fas fa-eye text-purple-500 mr-2"></i>
                                            a consulté 
                                            @if ($consultation->support)
                                                <span class="font-semibold text-purple-700 bg-purple-100 px-2 py-1 rounded break-words">
                                                    "{{ $consultation->support->titre }}"
                                                </span>
                                            @else
                                                <span class="text-gray-500 italic">Support inconnu</span>
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Métadonnées -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                        <!-- Type -->
                                        <div class="bg-white rounded-lg border border-gray-100 p-3">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-tag text-purple-500"></i>
                                                <div>
                                                    <div class="font-medium text-gray-600 text-xs">Type:</div>
                                                    <div class="text-purple-700 font-semibold">
                                                        {{ optional(optional($consultation->support)->type)->nom ?? 'Inconnu' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Matière -->
                                        <div class="bg-white rounded-lg border border-gray-100 p-3">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-book text-purple-500"></i>
                                                <div>
                                                    <div class="font-medium text-gray-600 text-xs">Matière:</div>
                                                    <div class="text-purple-700 font-semibold">
                                                        {{ $consultation->support->matiere->Nom ?? 'Non spécifiée' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Date -->
                                        <div class="bg-white rounded-lg border border-gray-100 p-3">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-clock text-purple-500"></i>
                                                <div>
                                                    <div class="font-medium text-gray-600 text-xs">Date:</div>
                                                    <div class="text-purple-700 font-semibold">
                                                        {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y à H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <!-- État vide stylisé -->
                <div class="empty-state text-center py-12 sm:py-16">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-purple-400 text-3xl sm:text-5xl"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Aucune consultation trouvée</h3>
                    <p class="text-gray-600 mb-6 sm:mb-8 max-w-md mx-auto px-4">
                        Aucune consultation n'a été enregistrée avec les filtres actuels. 
                        Essayez de modifier vos critères de recherche.
                    </p>
                    <a href="{{ route('admin.consultations') }}" class="inline-flex items-center px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl font-semibold text-sm sm:text-base">
                        <i class="fas fa-refresh mr-2 sm:mr-3"></i>
                        Réinitialiser les filtres
                    </a>
                </div>
            @endforelse

            {{-- Pagination améliorée --}}
            @if($consultations->hasPages())
                <div class="pagination-section mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                    <div class="flex flex-col items-center justify-between gap-4">
                        <!-- Info affichage -->
                        <div class="text-xs sm:text-sm text-gray-600 bg-gray-50 px-3 sm:px-4 py-2 rounded-lg text-center">
                            <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                            Affichage de <span class="font-semibold text-purple-700">{{ $consultations->firstItem() }}</span> à 
                            <span class="font-semibold text-purple-700">{{ $consultations->lastItem() }}</span> 
                            sur <span class="font-semibold text-purple-700">{{ $consultations->total() }}</span> consultations
                        </div>

                        <!-- Pagination -->
                        <div class="flex items-center space-x-1 sm:space-x-2 overflow-x-auto pb-2">
                            {{-- Bouton page précédente --}}
                            @if ($consultations->onFirstPage())
                                <span class="px-2 sm:px-4 py-2 rounded-lg cursor-not-allowed bg-gray-100 text-gray-400 flex-shrink-0" aria-disabled="true">
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