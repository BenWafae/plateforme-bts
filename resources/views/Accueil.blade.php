@extends('layouts.cours_public')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(request()->has('matiere_id'))
    <!-- Affichage des supports avec les boutons fonctionnels - DESIGN AMÉLIORÉ -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($supports as $support)
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border-t-4 border-violet-custom transform hover:-translate-y-1">
            <div class="p-5">
                <div class="flex items-start mb-3">
                    @if($support->format === 'pdf')
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-file-pdf text-violet-custom text-xl"></i>
                        </div>
                    @elseif(strpos($support->format, 'video') !== false)
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fab fa-youtube text-violet-custom text-xl"></i>
                        </div>
                    @elseif(in_array($support->format, ['ppt', 'pptx']))
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-file-powerpoint text-violet-custom text-xl"></i>
                        </div>
                    @elseif(in_array($support->format, ['doc', 'docx']))
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-file-word text-violet-custom text-xl"></i>
                        </div>
                    @elseif(in_array($support->format, ['xls', 'xlsx']))
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-file-excel text-violet-custom text-xl"></i>
                        </div>
                    @elseif($support->format === 'zip')
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-file-archive text-violet-custom text-xl"></i>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-file text-violet-custom text-xl"></i>
                        </div>
                    @endif
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800">{{ $support->titre }}</h5>
                        <span class="inline-block bg-violet-50 text-violet-custom px-2 py-1 rounded text-xs font-medium uppercase">
                            {{ strtoupper($support->format) }}
                        </span>
                    </div>
                </div>
                
                <div class="pl-15 border-l-2 border-violet-50 ml-6 pl-4 mb-4">
                    <p class="text-gray-600 text-sm mb-2 flex items-center">
                        <i class="fas fa-book mr-2 text-violet-custom"></i> 
                        {{ $matieres->firstWhere('id_Matiere', request('matiere_id'))->Nom }}
                    </p>
                    <p class="text-gray-600 text-sm flex items-center">
                        <i class="far fa-calendar mr-2 text-violet-custom"></i> 
                        {{ $support->created_at->format('d/m/Y') }}
                    </p>
                    <p class="text-gray-600 text-sm flex items-center mt-2">
                        <i class="fas fa-weight mr-2 text-violet-custom"></i> 
                        {{ round($support->taille / 1024) }} KB
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-100">
                @if($support->format === 'pdf')
                    <a href="{{ route('fichiers.view', $support->id_support) }}" class="flex items-center justify-center py-3 bg-violet-50 text-violet-custom hover:bg-violet-custom hover:text-white transition-colors rounded-b-lg" target="_blank" rel="noopener">
                        <i class="fas fa-eye mr-2"></i> Voir PDF
                    </a>
                @elseif(strpos($support->format, 'video') !== false && filter_var($support->lien_url, FILTER_VALIDATE_URL))
                    <a href="{{ $support->lien_url }}" target="_blank" class="flex items-center justify-center py-3 bg-violet-50 text-violet-custom hover:bg-violet-custom hover:text-white transition-colors rounded-b-lg">
                        <i class="fab fa-youtube mr-2"></i> Regarder sur YouTube
                    </a>
                @elseif(in_array($support->format, ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'zip']))
                    <a href="{{ route('fichiers.download', $support->id_support) }}" class="flex items-center justify-center py-3 bg-violet-50 text-violet-custom hover:bg-violet-custom hover:text-white transition-colors rounded-b-lg">
                        <i class="fas fa-download mr-2"></i> Télécharger
                    </a>
                @else
                    <a href="{{ route('fichiers.download', $support->id_support) }}" class="flex items-center justify-center py-3 bg-violet-50 text-violet-custom hover:bg-violet-custom hover:text-white transition-colors rounded-b-lg">
                        <i class="fas fa-download mr-2"></i> Télécharger
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <!-- Enhanced empty state design -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-folder-open text-violet-custom text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucun contenu disponible</h3>
                        <p class="text-gray-600 max-w-md mb-6">
                            Aucun {{ request('type') }} n'est actuellement disponible pour cette matière. Veuillez vérifier ultérieurement ou explorer d'autres matières.
                        </p>
                        <div class="flex flex-wrap justify-center gap-3">
                            <a href="?type={{ request('type') }}" class="px-4 py-2 bg-violet-custom text-white rounded-md hover:bg-violet-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Retour aux matières
                            </a>
                            <a href="/" class="px-4 py-2 border border-violet-custom text-violet-custom rounded-md hover:bg-violet-50 transition-colors">
                                <i class="fas fa-home mr-2"></i> Accueil
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 text-center">
                        <i class="fas fa-info-circle mr-1"></i> Les ressources sont régulièrement mises à jour par l'équipe pédagogique.
                    </p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @elseif(request()->has('type'))
    <!-- Filtres de sélection - affichage horizontal progressif -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="flex items-center text-lg font-semibold mb-6 text-gray-800">
            <i class="fas fa-filter mr-2 text-violet-custom"></i> Navigation des ressources :
            <span class="ml-2 bg-violet-custom text-white px-2 py-1 rounded-md text-sm">
                {{ ucfirst(request('type')) }}
            </span>
        </h2>

        <div class="flex flex-wrap gap-6">
            <!-- Étape 1 : Années -->
            <div class="min-w-[150px]">
                <h6 class="font-medium text-gray-700 mb-3">Année</h6>
                <div class="flex flex-col space-y-2">
                    <a href="?type={{ request('type') }}&annee=1"
                       class="px-4 py-2 rounded-md text-center transition-colors {{ request('annee') == 1 ? 'bg-violet-custom text-white' : 'border border-violet-custom text-violet-custom hover:bg-violet-50' }}">
                        1ère année
                    </a>
                    <a href="?type={{ request('type') }}&annee=2"
                       class="px-4 py-2 rounded-md text-center transition-colors {{ request('annee') == 2 ? 'bg-violet-custom text-white' : 'border border-violet-custom text-violet-custom hover:bg-violet-50' }}">
                        2ème année
                    </a>
                </div>
            </div>

            <!-- Étape 2 : Filières -->
            @if(request()->has('annee'))
            <div class="min-w-[180px]">
                <h6 class="font-medium text-gray-700 mb-3">Filière</h6>
                <div class="flex flex-col space-y-2">
                    @foreach($filieres as $filiere)
                    <a href="?type={{ request('type') }}&annee={{ request('annee') }}&filiere_id={{ $filiere->id_filiere }}"
                       class="px-4 py-2 rounded-md text-center transition-colors {{ request('filiere_id') == $filiere->id_filiere ? 'bg-violet-custom text-white' : 'border border-violet-custom text-violet-custom hover:bg-violet-50' }}">
                        {{ $filiere->nom_filiere }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Étape 3 : Matières -->
            @if(request()->has('filiere_id'))
            <div class="min-w-[180px]">
                <h6 class="font-medium text-gray-700 mb-3">Matière</h6>
                <div class="flex flex-col space-y-2">
                    @foreach($matieres->where('id_filiere', request('filiere_id')) as $matiere)
                    <a href="?type={{ request('type') }}&annee={{ request('annee') }}&filiere_id={{ request('filiere_id') }}&matiere_id={{ $matiere->id_Matiere }}"
                       class="px-4 py-2 rounded-md text-center transition-colors {{ request('matiere_id') == $matiere->id_Matiere ? 'bg-violet-custom text-white' : 'border border-violet-custom text-violet-custom hover:bg-violet-50' }}">
                        {{ $matiere->Nom }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Message guide - Enhanced with more elegant design -->
    @unless(request()->has('matiere_id'))
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-violet-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fas {{ request()->has('filiere_id') ? 'fa-book' : (request()->has('annee') ? 'fa-graduation-cap' : 'fa-search') }} text-violet-custom text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">
                    @if(request()->has('filiere_id'))
                    Sélectionnez une matière
                    @elseif(request()->has('annee'))
                    Sélectionnez une filière
                    @else
                    Sélectionnez une année académique
                    @endif
                </h3>
                <p class="text-gray-600 max-w-md mb-6">
                    @if(request()->has('filiere_id'))
                    Choisissez une matière pour accéder aux ressources pédagogiques disponibles.
                    @elseif(request()->has('annee'))
                    Sélectionnez votre filière pour découvrir les matières associées.
                    @else
                    Commencez par choisir votre niveau d'études pour accéder aux ressources adaptées.
                    @endif
                </p>
                
                @if(!request()->has('annee'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-md">
                    <a href="?type={{ request('type') }}&annee=1" class="flex items-center justify-center gap-2 px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <i class="fas fa-user-graduate"></i>
                        <span>1ère année</span>
                    </a>
                    <a href="?type={{ request('type') }}&annee=2" class="flex items-center justify-center gap-2 px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <i class="fas fa-user-graduate"></i>
                        <span>2ème année</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500 text-center">
                <i class="fas fa-info-circle mr-1"></i> Utilisez les filtres ci-dessus pour naviguer entre les différentes ressources.
            </p>
        </div>
    </div>
    @endunless

    @else
    <!-- Page d'accueil -->
    <div class="max-w-6xl mx-auto">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-violet-custom to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-12">
            <div class="px-6 py-12 sm:px-12 sm:py-16 md:py-20 text-center text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-6">
                    Bienvenue sur la plateforme BTS AI Idrissi
                </h1>
                <p class="text-lg sm:text-xl opacity-90 max-w-3xl mx-auto mb-8">
                    Accédez à toutes vos ressources pédagogiques en un seul endroit. Cours, exercices et examens pour réussir votre BTS.
                </p>
                
                <!-- Boutons d'action -->
                <div class="flex flex-wrap justify-center gap-4 mt-6">
                    <a href="#resources" class="px-6 py-3 bg-white text-violet-custom rounded-lg font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
                        <i class="fas fa-arrow-down mr-2"></i> Découvrir les ressources
                    </a>
                    <a href="#filieres" class="px-6 py-3 bg-violet-800 bg-opacity-50 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 hover:bg-opacity-70">
                        <i class="fas fa-graduation-cap mr-2"></i> Nos filières
                    </a>
                </div>
            </div>
        </div>

        <!-- Resource Cards -->
        <div id="resources" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Cours Card -->
            <a href="?type=cours" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-50 text-violet-custom mb-4 group-hover:bg-violet-custom group-hover:text-white transition-colors">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-gray-800">Cours</h2>
                    <p class="text-gray-600 mb-4">
                        Accédez à tous les supports de cours pour approfondir vos connaissances
                    </p>
                    <div class="inline-flex items-center text-violet-custom font-medium group-hover:text-violet-700">
                        Découvrir <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </div>
                </div>
            </a>

            <!-- Exercices Card -->
            <a href="?type=td" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-50 text-violet-custom mb-4 group-hover:bg-violet-custom group-hover:text-white transition-colors">
                        <i class="fas fa-tasks text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-gray-800">Exercices</h2>
                    <p class="text-gray-600 mb-4">
                        Pratiquez avec des exercices pour consolider vos apprentissages
                    </p>
                    <div class="inline-flex items-center text-violet-custom font-medium group-hover:text-violet-700">
                        Découvrir <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </div>
                </div>
            </a>

            <!-- Examens Card -->
            <a href="?type=examens" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-50 text-violet-custom mb-4 group-hover:bg-violet-custom group-hover:text-white transition-colors">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-gray-800">Examens</h2>
                    <p class="text-gray-600 mb-4">
                        Préparez-vous aux examens avec des sujets et annales corrigés
                    </p>
                    <div class="inline-flex items-center text-violet-custom font-medium group-hover:text-violet-700">
                        Découvrir <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Features Section -->
        <div id="about" class="bg-white rounded-xl shadow-md p-8 mb-12">
            <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Pourquoi utiliser notre plateforme ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-violet-100 text-violet-custom mb-4">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Accès rapide</h3>
                    <p class="text-gray-600">Trouvez rapidement les ressources dont vous avez besoin</p>
                </div>
                <div class="text-center p-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-violet-100 text-violet-custom mb-4">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Contenu organisé</h3>
                    <p class="text-gray-600">Ressources classées par année, filière et matière</p>
                </div>
                <div class="text-center p-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-violet-100 text-violet-custom mb-4">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Formats variés</h3>
                    <p class="text-gray-600">PDF, vidéos et autres formats pour tous les styles d'apprentissage</p>
                </div>
            </div>
        </div>
        
        <!-- NOUVELLE SECTION: Présentation des filières avec icônes adaptées -->
        <div id="filieres" class="bg-white rounded-xl shadow-md p-8 mb-12">
            <h2 class="text-2xl font-bold text-center mb-10 text-gray-800">Nos filières BTS</h2>
            
            <!-- Filière 1: Système et Réseau Informatique -->
            <div class="mb-12 border-b border-gray-100 pb-10">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-24 h-24 flex-shrink-0 bg-violet-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-network-wired text-violet-custom text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Système et Réseau Informatique</h3>
                        <p class="text-gray-600 mb-4">
                            Cette filière forme des techniciens supérieurs capables de gérer, maintenir et sécuriser les infrastructures informatiques d'une entreprise. Les étudiants acquièrent des compétences en administration réseau, cybersécurité, programmation et gestion de bases de données.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-server text-violet-custom mr-2"></i>
                                <span>Réseaux Informatiques</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-shield-alt text-violet-custom mr-2"></i>
                                <span>Windows et Gnu/Linux</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-code text-violet-custom mr-2"></i>
                                <span>Développement Informatiques</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filière 2: Conception du Produit Industriel -->
            <div class="mb-12 border-b border-gray-100 pb-10">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-24 h-24 flex-shrink-0 bg-violet-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-drafting-compass text-violet-custom text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Conception du Produit Industriel</h3>
                        <p class="text-gray-600 mb-4">
                            Cette filière forme des concepteurs capables de participer à la création et à l'amélioration de produits industriels. Les étudiants maîtrisent les outils de CAO/DAO, les techniques de modélisation 3D et les processus de fabrication industrielle.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-pencil-ruler text-violet-custom mr-2"></i>
                                <span>Motorisation et commande des S.Industriels</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-cube text-violet-custom mr-2"></i>
                                <span>Modélisation et comportement des S.industriels</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-cogs text-violet-custom mr-2"></i>
                                <span>Motorisations</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filière 3: Système Électronique -->
            <div class="mb-12 border-b border-gray-100 pb-10">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-24 h-24 flex-shrink-0 bg-violet-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-microchip text-violet-custom text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Système Électronique</h3>
                        <p class="text-gray-600 mb-4">
                            Cette filière forme des techniciens spécialisés dans la conception, l'installation et la maintenance de systèmes électroniques. Les étudiants développent des compétences en électronique analogique et numérique, en programmation embarquée et en automatisme.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-wave-square text-violet-custom mr-2"></i>
                                <span>Électronique </span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-atom text-violet-custom mr-2"></i>
                                <span>Physiques Appliquées</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-laptop-code text-violet-custom mr-2"></i>
                                <span>Informatiques Industriels</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filière 4: Électromécanique et Système Automatisé -->
            <div class="mb-12 border-b border-gray-100 pb-10">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-24 h-24 flex-shrink-0 bg-violet-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-industry text-violet-custom text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Électromécanique et Système Automatisé</h3>
                        <p class="text-gray-600 mb-4">
                            Cette filière forme des techniciens polyvalents capables d'intervenir sur des systèmes combinant mécanique, électricité et automatisme. Les étudiants maîtrisent la maintenance industrielle, la programmation d'automates et la gestion de production.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-cog text-violet-custom mr-2"></i>
                                <span>Productique</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-bolt text-violet-custom mr-2"></i>
                                <span>Commandes des systèmes Industriels</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-sitemap text-violet-custom mr-2"></i>
                                <span>Motorisation du système industriels</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filière 5: Gestion des Petites et Moyennes Entreprises -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-24 h-24 flex-shrink-0 bg-violet-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-violet-custom text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Gestion des Petites et Moyennes Entreprises</h3>
                        <p class="text-gray-600 mb-4">
                            Cette filière forme des gestionnaires polyvalents capables d'assurer la gestion administrative, financière et commerciale d'une PME. Les étudiants développent des compétences en comptabilité, marketing, ressources humaines et droit des affaires.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-calculator text-violet-custom mr-2"></i>
                                <span>Comptabilité</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-balance-scale text-violet-custom mr-2"></i>
                                <span>Droit, Économie et Management</span>
                            </div>
                            <div class="bg-violet-50 p-3 rounded-lg flex items-center">
                                <i class="fas fa-desktop text-violet-custom mr-2"></i>
                                <span>Informatiques de gestion</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistiques -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-12">
            <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Notre plateforme en chiffres</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-4 border-r border-gray-100 last:border-r-0">
                    <div class="text-4xl font-bold text-violet-custom mb-2">100+</div>
                    <p class="text-gray-600">Cours disponibles</p>
                </div>
                <div class="text-center p-4 border-r border-gray-100 last:border-r-0">
                    <div class="text-4xl font-bold text-violet-custom mb-2">50+</div>
                    <p class="text-gray-600">Exercices pratiques</p>
                </div>
                <div class="text-center p-4 border-r border-gray-100 last:border-r-0">
                    <div class="text-4xl font-bold text-violet-custom mb-2">30+</div>
                    <p class="text-gray-600">Examens corrigés</p>
                </div>
                <div class="text-center p-4">
                    <div class="text-4xl font-bold text-violet-custom mb-2">5+</div>
                    <p class="text-gray-600">Filières couvertes</p>
                </div>
            </div>
        </div>
        
        <!-- MISE À JOUR: Témoignages des lauréats -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-12">
            <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Nos lauréats témoignent</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-violet-50 p-6 rounded-lg border-l-4 border-violet-custom">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-violet-200 rounded-full flex items-center justify-center mr-4">
                            <span class="text-violet-custom font-bold">OB</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Ouiam Bouhadou</h4>
                            <p class="text-sm text-gray-500">Lauréate en Système et Réseau Informatique</p>
                            <p class="text-xs text-violet-custom font-medium">Major de promotion 2024</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Grâce à la qualité de l'enseignement et aux ressources pédagogiques disponibles, j'ai pu développer des compétences solides qui m'ont permis d'intégrer rapidement le marché du travail. La plateforme a été un outil précieux tout au long de ma formation."</p>
                </div>
                <div class="bg-violet-50 p-6 rounded-lg border-l-4 border-violet-custom">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-violet-200 rounded-full flex items-center justify-center mr-4">
                            <span class="text-violet-custom font-bold">KG</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Karima Gouhi</h4>
                            <p class="text-sm text-gray-500">Lauréate en Système et Réseau Informatique</p>
                            <p class="text-xs text-violet-custom font-medium">Major de promotion 2023</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Mon parcours au BTS AI Idrissi a été une expérience enrichissante qui m'a ouvert de nombreuses portes. Les connaissances acquises et la méthodologie de travail m'ont permis de poursuivre mes études avec succès et de me démarquer dans mon domaine."</p>
                </div>
            </div>
        </div>
        
         <!-- SECTION CONTACT AMÉLIORÉE sans formulaire -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
            <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-8 sm:px-12 text-white">
                <h2 class="text-2xl font-bold mb-2 text-center">Contactez-nous</h2>
                <p class="text-center opacity-90 max-w-2xl mx-auto">
                    Vous avez des questions sur nos formations ou besoin d'assistance ? N'hésitez pas à nous contacter.
                </p>
            </div>
            
            <div class="p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-violet-50 rounded-xl p-6 text-center transform transition-transform hover:-translate-y-1 hover:shadow-md">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 text-violet-custom mb-4 mx-auto">
                            <i class="fas fa-map-marker-alt text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Adresse</h3>
                        <p class="text-gray-600">Lycée Techniques Alidrissi Bp 5097 QL AGADIR</p>
                    </div>
                    
                    <div class="bg-violet-50 rounded-xl p-6 text-center transform transition-transform hover:-translate-y-1 hover:shadow-md">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 text-violet-custom mb-4 mx-auto">
                            <i class="fas fa-phone text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Téléphone</h3>
                        <p class="text-gray-600">05 28 22 81 69</p>
                    </div>
                    
                    <div class="bg-violet-50 rounded-xl p-6 text-center transform transition-transform hover:-translate-y-1 hover:shadow-md">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 text-violet-custom mb-4 mx-auto">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Email</h3>
                        <p class="text-gray-600">contact@btsidrissi.ma</p>
                    </div>
                    
                    <div class="bg-violet-50 rounded-xl p-6 text-center transform transition-transform hover:-translate-y-1 hover:shadow-md">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 text-violet-custom mb-4 mx-auto">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Horaires</h3>
                        <p class="text-gray-600">Lundi - Vendredi: 8h30 - 18h30</p>
                    </div>
                </div>
                
                <div class="mt-10 text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Suivez-nous sur les réseaux sociaux</h3>
                    <div class="flex justify-center space-x-6">
                        <a href="#" class="w-12 h-12 rounded-full bg-violet-100 flex items-center justify-center text-violet-custom hover:bg-violet-custom hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/bts_agadir?igsh=dGRrZmMwYWJiYnNp" class="w-12 h-12 rounded-full bg-violet-100 flex items-center justify-center text-violet-custom hover:bg-violet-custom hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="http://www.lyceealidrissi.net" class="w-12 h-12 rounded-full bg-violet-100 flex items-center justify-center text-violet-custom hover:bg-violet-custom hover:text-white transition-colors">
                            <i class="fas fa-globe text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
