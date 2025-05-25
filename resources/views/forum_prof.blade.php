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
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Animation pour les boutons */
        .btn-hover {
            transition: all 0.2s ease;
        }
        .btn-hover:hover {
            transform: translateY(-1px);
        }

        /* Style pour les réponses */
        .response-card {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }
        .response-card:hover {
            border-left-color: #5E60CE;
            background-color: rgba(94, 96, 206, 0.02);
        }
    </style>
@endsection

@section('breadcrumb', 'Forum - Questions')

@section('content')
<div class="p-6 lg:p-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-violet-custom to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-8 sm:px-12 text-center text-white">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white bg-opacity-20 mb-4">
                    <i class="fas fa-comments text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold mb-2">Forum - Questions des étudiants</h1>
                <p class="text-lg opacity-90">Répondez aux questions posées dans vos matières</p>
            </div>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Liste des questions -->
    <div class="space-y-6">
        @forelse ($questions as $question)
            <div class="card-hover bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- En-tête de la question -->
                <div class="bg-gradient-to-r from-violet-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Avatar de l'utilisateur -->
                            <div class="w-12 h-12 rounded-full bg-violet-100 flex items-center justify-center flex-shrink-0">
                                @php
                                    $prenom = $question->user->prenom ?? 'U';
                                    $nom = $question->user->nom ?? 'U';
                                    $initials = strtoupper(substr($prenom, 0, 1)) . strtoupper(substr($nom, 0, 1));
                                @endphp
                                <span class="text-violet-custom font-bold text-lg">{{ $initials }}</span>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-user mr-1 text-violet-custom"></i>
                                    <strong>Posée par :</strong> {{ $question->user->nom }} {{ $question->user->prenom }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-book mr-1 text-violet-custom"></i>
                                    <strong>Matière :</strong> {{ $question->matiere->Nom }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-3 sm:mt-0">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-violet-100 text-violet-custom">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contenu de la question -->
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-question-circle text-violet-custom mr-2"></i>
                        {{ $question->titre }}
                    </h2>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <p class="text-gray-700 leading-relaxed">{{ $question->contenue }}</p>
                    </div>

                    <!-- Section des réponses -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-reply text-violet-custom mr-2"></i>
                            Réponses ({{ $question->reponses->count() }})
                        </h3>

                        @if($question->reponses->count() > 0)
                            <div class="space-y-4">
                                @foreach ($question->reponses as $reponse)
                                    <div class="response-card bg-violet-50 rounded-lg p-4 border border-violet-100">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-3 flex-1">
                                                <!-- Avatar du répondant -->
                                                <div class="w-10 h-10 rounded-full bg-violet-200 flex items-center justify-center flex-shrink-0">
                                                    @php
                                                        $prenomReponse = $reponse->user->prenom ?? 'U';
                                                        $nomReponse = $reponse->user->nom ?? 'U';
                                                        $initialsReponse = strtoupper(substr($prenomReponse, 0, 1)) . strtoupper(substr($nomReponse, 0, 1));
                                                    @endphp
                                                    <span class="text-violet-custom font-bold">{{ $initialsReponse }}</span>
                                                </div>
                                                
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <span class="font-medium text-gray-800">{{ $reponse->user->nom }} {{ $reponse->user->prenom }}</span>
                                                        <span class="text-xs text-gray-500">•</span>
                                                        <span class="text-xs text-gray-500">{{ $reponse->created_at->format('d/m/Y à H:i') }}</span>
                                                    </div>
                                                    <p class="text-gray-700">{{ $reponse->contenu }}</p>
                                                </div>
                                            </div>

                                            <!-- Actions pour les réponses du professeur connecté -->
                                            @if ($reponse->id_user == auth()->user()->id_user)
                                                <div class="flex items-center space-x-2 ml-4">
                                                    <a href="{{ route('professeur.reponse.edit', $reponse->id) }}" 
                                                       class="btn-hover inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors"
                                                       title="Modifier">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('professeur.reponse.destroy', $reponse->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn-hover inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                                                                title="Supprimer"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?')">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-comment-slash text-violet-custom text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Aucune réponse pour le moment</p>
                                <p class="text-sm text-gray-400">Soyez le premier à répondre à cette question</p>
                            </div>
                        @endif
                    </div>

                    <!-- Formulaire pour ajouter une réponse -->
                    <div class="bg-gray-50 rounded-lg p-6 border-t-4 border-violet-custom">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-reply text-violet-custom mr-2"></i>
                            Ajouter une réponse
                        </h4>
                        
                        <form action="{{ route('professeur.questions.repondre', $question->id_question) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <textarea name="reponse" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-custom focus:border-violet-custom transition-colors resize-none" 
                                          rows="4" 
                                          placeholder="Tapez votre réponse ici..."
                                          required></textarea>
                                @error('reponse')
                                    <div class="mt-2 text-red-600 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="btn-hover inline-flex items-center px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors font-medium">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Publier la réponse
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <!-- État vide -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-comments text-violet-custom text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucune question pour le moment</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-6">
                    Les étudiants n'ont pas encore posé de questions dans vos matières. 
                    Les nouvelles questions apparaîtront ici.
                </p>
                <div class="inline-flex items-center text-violet-custom font-medium">
                    <i class="fas fa-info-circle mr-2"></i>
                    Revenez plus tard pour voir les nouvelles questions
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($questions->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                <div class="px-6 py-4">
                    {{ $questions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Style personnalisé pour la pagination */
.pagination {
    margin: 0;
}

.pagination .page-link {
    color: #5E60CE;
    border-color: #e5e7eb;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    color: white;
    background-color: #5E60CE;
    border-color: #5E60CE;
    transform: translateY(-1px);
}

.pagination .page-item.active .page-link {
    background-color: #5E60CE;
    border-color: #5E60CE;
    color: white;
}

.pagination .page-item.disabled .page-link {
    color: #9ca3af;
    background-color: #f9fafb;
    border-color: #e5e7eb;
}
</style>
@endsection

