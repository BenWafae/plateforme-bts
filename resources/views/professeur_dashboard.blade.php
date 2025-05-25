@extends('layouts.professeur')

@section('head')
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
    </style>
@endsection

@section('breadcrumb', 'Tableau de bord')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Section d'accueil -->
    <div class="text-center mb-12">
        <div class="bg-gradient-to-br from-violet-custom to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-12 sm:px-12 sm:py-16 text-center text-white">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white bg-opacity-20 mb-6">
                    <i class="fas fa-chalkboard-teacher text-3xl"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4">
                    Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </h1>
                <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                    Accédez à votre espace personnel pour gérer les supports, répondre aux questions, et accompagner les étudiants dans leur réussite.
                </p>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Carte Supports -->
        <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-violet-custom to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-folder text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Supports éducatifs</h3>
                            <p class="text-sm text-gray-600">Total créés</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-violet-custom">{{ $nombreSupports }}</div>
                        <div class="text-sm text-gray-500">documents</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-violet-custom">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Gérer mes supports</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Questions -->
        <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-violet-custom rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-comments text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Questions reçues</h3>
                            <p class="text-sm text-gray-600">Dans vos matières</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-violet-custom">{{ $nombreQuestionsDansMatieres }}</div>
                        <div class="text-sm text-gray-500">questions</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-violet-custom">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Répondre aux questions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers supports ajoutés -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-folder-plus mr-3"></i>
                Derniers supports ajoutés
            </h2>
        </div>
        
        <div class="p-6">
            @if ($derniersSupports->isEmpty())
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-violet-custom text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucun support ajouté</h3>
                    <p class="text-gray-600 mb-6">Commencez par ajouter votre premier support éducatif</p>
                    <a href="{{ route('supports.create') }}" class="inline-flex items-center px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter un support
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($derniersSupports as $support)
                        <div class="list-item-hover flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 rounded-lg border border-gray-100">
                            <div class="flex items-start space-x-4">
                                <!-- Icône du type de fichier -->
                                <div class="w-12 h-12 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                                    @if (strpos($support->lien_url, '.pdf') !== false)
                                        <i class="fas fa-file-pdf text-violet-custom text-xl"></i>
                                    @elseif (strpos($support->lien_url, '.docx') !== false)
                                        <i class="fas fa-file-word text-violet-custom text-xl"></i>
                                    @elseif (strpos($support->lien_url, '.pptx') !== false)
                                        <i class="fas fa-file-powerpoint text-violet-custom text-xl"></i>
                                    @elseif (strpos($support->lien_url, 'youtube.com') !== false || strpos($support->lien_url, 'youtu.be') !== false)
                                        <i class="fab fa-youtube text-violet-custom text-xl"></i>
                                    @else
                                        <i class="fas fa-file text-violet-custom text-xl"></i>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $support->titre }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-tag mr-1 text-violet-custom"></i>
                                            {{ strtoupper($support->format) }}
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-book mr-1 text-violet-custom"></i>
                                            {{ $support->matiere ? $support->matiere->Nom : 'Non spécifiée' }}
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-calendar mr-1 text-violet-custom"></i>
                                            {{ $support->created_at->format('d/m/Y à H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                                @if (strpos($support->lien_url, '.pdf') !== false)
                                    <a href="{{ route('support.showPdf', ['id' => $support->id_support]) }}" 
                                       class="icon-shine inline-flex items-center justify-center w-10 h-10 bg-violet-100 text-violet-custom rounded-lg hover:bg-violet-custom hover:text-white transition-all"
                                       title="Voir le PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                @elseif (strpos($support->lien_url, '.docx') !== false || strpos($support->lien_url, '.pptx') !== false)
                                    <a href="{{ route('support.showPdf', ['id' => $support->id_support]) }}" 
                                       class="icon-shine inline-flex items-center justify-center w-10 h-10 bg-violet-100 text-violet-custom rounded-lg hover:bg-violet-custom hover:text-white transition-all"
                                       title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @elseif (strpos($support->lien_url, 'youtube.com') !== false || strpos($support->lien_url, 'youtu.be') !== false)
                                    <a href="{{ $support->lien_url }}" target="_blank" 
                                       class="icon-shine inline-flex items-center justify-center w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all"
                                       title="Voir sur YouTube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @else
                                    <a href="{{ $support->lien_url }}" target="_blank" 
                                       class="icon-shine inline-flex items-center justify-center w-10 h-10 bg-violet-100 text-violet-custom rounded-lg hover:bg-violet-custom hover:text-white transition-all"
                                       title="Ouvrir le fichier">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('supports.index') }}" class="inline-flex items-center text-violet-custom hover:text-violet-700 font-medium">
                        Voir tous les supports
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Dernières questions posées -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-question-circle mr-3"></i>
                Dernières questions posées dans vos matières
            </h2>
        </div>
        
        <div class="p-6">
            @if ($dernieresQuestions->isEmpty())
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-violet-custom text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucune question récente</h3>
                    <p class="text-gray-600 mb-6">Les étudiants n'ont pas encore posé de questions dans vos matières</p>
                    <a href="{{ route('professeur.questions.index') }}" class="inline-flex items-center px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <i class="fas fa-comments mr-2"></i>
                        Voir le forum
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($dernieresQuestions as $question)
                        <div class="list-item-hover flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 rounded-lg border border-gray-100">
                            <div class="flex items-start space-x-4">
                                <!-- Avatar de l'utilisateur -->
                                <div class="w-12 h-12 rounded-full bg-violet-100 flex items-center justify-center flex-shrink-0">
                                    @php
                                        $prenom = $question->user->prenom ?? 'U';
                                        $nom = $question->user->nom ?? 'U';
                                        $initials = strtoupper(substr($prenom, 0, 1)) . strtoupper(substr($nom, 0, 1));
                                    @endphp
                                    <span class="text-violet-custom font-bold">{{ $initials }}</span>
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $question->titre }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-user mr-1 text-violet-custom"></i>
                                            {{ $question->user->prenom ?? 'Utilisateur' }} {{ $question->user->nom ?? '' }}
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-book mr-1 text-violet-custom"></i>
                                            {{ $question->matiere->Nom ?? 'Non spécifiée' }}
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-calendar mr-1 text-violet-custom"></i>
                                            {{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y à H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 sm:mt-0">
                                <a href="{{ route('professeur.questions.show', ['id' => $question->id_question]) }}" 
                                   class="icon-shine inline-flex items-center justify-center w-10 h-10 bg-violet-100 text-violet-custom rounded-lg hover:bg-violet-custom hover:text-white transition-all"
                                   title="Voir la question">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('professeur.questions.index') }}" class="inline-flex items-center text-violet-custom hover:text-violet-700 font-medium">
                        Voir toutes les questions
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

