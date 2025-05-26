@extends('layouts.admin')

@section('content')
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

        /* Style pour les avatars */
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        /* Badge de statut */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

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

    <div class="container mx-auto px-6 py-8">
        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-violet-custom to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-8 sm:px-12 text-center text-white">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white bg-opacity-20 mb-4">
                        <i class="fas fa-comments text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Gestion des Questions</h1>
                    <p class="text-lg opacity-90">Administrez les questions posées par les étudiants</p>
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
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-list mr-3"></i>
                    Liste des Questions
                </h2>
            </div>

            <div class="p-6">
                @if($questions->count() > 0)
                    <div class="space-y-4">
                        @foreach($questions as $question)
                            <div class="card-hover bg-white border border-gray-200 rounded-lg p-6 hover:border-violet-custom transition-all duration-200">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <!-- Informations de la question -->
                                    <div class="flex items-start space-x-4 flex-1">
                                        <!-- Avatar de l'utilisateur -->
                                        <div class="user-avatar flex-shrink-0">
                                            @php
                                                $prenom = $question->user->prenom ?? 'U';
                                                $nom = $question->user->nom ?? 'U';
                                                $initials = strtoupper(substr($prenom, 0, 1)) . strtoupper(substr($nom, 0, 1));
                                            @endphp
                                            {{ $initials }}
                                        </div>

                                        <!-- Détails de la question -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $question->titre }}</h3>
                                            
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                                                <span class="flex items-center">
                                                    <i class="fas fa-user mr-1 text-violet-custom"></i>
                                                    <strong>Posée par:</strong> {{ $question->user->nom }} {{ $question->user->prenom }}
                                                </span>
                                                
                                                <span class="flex items-center">
                                                    <i class="fas fa-calendar mr-1 text-violet-custom"></i>
                                                    {{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y à H:i') }}
                                                </span>

                                                @if($question->matiere)
                                                    <span class="flex items-center">
                                                        <i class="fas fa-book mr-1 text-violet-custom"></i>
                                                        {{ $question->matiere->Nom }}
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Aperçu du contenu -->
                                            @if($question->contenue)
                                                <p class="text-gray-600 text-sm line-clamp-2">
                                                    {{ Str::limit($question->contenue, 150) }}
                                                </p>
                                            @endif

                                            <!-- Badges de statut -->
                                            <div class="flex items-center gap-2 mt-3">
                                                <span class="status-badge bg-violet-100 text-violet-custom">
                                                    <i class="fas fa-reply mr-1"></i>
                                                    {{ $question->reponses->count() }} réponse(s)
                                                </span>
                                                
                                                @if($question->created_at >= now()->subDays(1))
                                                    <span class="status-badge bg-green-100 text-green-700">
                                                        <i class="fas fa-star mr-1"></i>
                                                        Nouveau
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-3 mt-4 lg:mt-0 lg:ml-6">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('admin.questions.show', $question->id_question) }}" 
                                           class="btn-hover inline-flex items-center justify-center w-10 h-10 bg-violet-100 text-violet-custom rounded-lg hover:bg-violet-custom hover:text-white transition-all"
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Bouton Supprimer -->
                                        <form action="{{ route('admin.questions.destroy', $question->id_question) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-hover inline-flex items-center justify-center w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all"
                                                    title="Supprimer la question"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ? Cette action est irréversible.')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination stylisée avec thème violet -->
                    @if($questions->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <span class="text-violet-custom mr-3 font-bold">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            Pages :
                                        </span>
                                        {{ $questions->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @else
                    <!-- État vide -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-comments text-violet-custom text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucune question trouvée</h3>
                        <p class="text-gray-600 max-w-md mx-auto mb-6">
                            Il n'y a actuellement aucune question dans le système. 
                            Les nouvelles questions apparaîtront ici une fois que les étudiants commenceront à les poser.
                        </p>
                        <div class="inline-flex items-center text-violet-custom font-medium">
                            <i class="fas fa-info-circle mr-2"></i>
                            Les questions seront automatiquement affichées ici
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Limitation du texte sur plusieurs lignes */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection







