@extends('layouts.professeur')

@section('head')
    {{-- Charger Tailwind uniquement pour cette page --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="text-center mt-5 pt-4">
    <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-900 mb-4">
        Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
    </h1>
    <p class="text-lg md:text-xl text-gray-800 max-w-xl mx-auto mb-6">
        Accédez à votre espace personnel pour gérer les supports, répondre aux questions, et accompagner les étudiants dans leur réussite.
    </p>
</div>

{{-- Cartes de statistiques --}}
<div class="mt-10 max-w-5xl mx-auto flex flex-col md:flex-row gap-6">
    <div class="flex-1 bg-white shadow-lg rounded-2xl p-4 border border-gray-200">
        <h2 class="text-xl font-semibold text-indigo-800 mb-4">Statistiques</h2>
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">Nombre de supports éducatifs</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $nombreSupports }}</div>
        </div>
    </div>

    <div class="flex-1 bg-white shadow-lg rounded-2xl p-4 border border-gray-200">
        <h2 class="text-xl font-semibold text-indigo-800 mb-4">Statistiques</h2>
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">Questions posées dans vos matières</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $nombreQuestionsDansMatieres }}</div>
        </div>
    </div>
</div>

{{-- Derniers supports ajoutés --}}
<div class="mt-10 max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg border border-gray-200">
    <h2 class="text-2xl font-semibold text-indigo-900 mb-4"> Derniers supports ajoutés</h2>

    @if ($derniersSupports->isEmpty())
        <p class="text-gray-500">Aucun support ajouté récemment.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach ($derniersSupports as $support)
                <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-indigo-800">{{ $support->titre }}</h3>
                        <p class="text-sm text-gray-600">
                            Format : {{ strtoupper($support->format) }} |
                            
                            {{-- Affichage de la matière --}}
                            @if($support->matiere)
                                Matière : {{ $support->matiere->Nom }} |
                            @else
                                Matière : Non spécifiée |
                            @endif
                            
                            Ajouté le {{ $support->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        {{-- Logique pour déterminer l'icône, le label et l'URL --}}
                        @if (strpos($support->lien_url, '.pdf') !== false)
                            <a href="{{ route('support.showPdf', ['id' => $support->id_support]) }}" class="text-blue-600">
                                <i class="fas fa-file-pdf"></i> 
                            </a>
                        @elseif (strpos($support->lien_url, '.docx') !== false || strpos($support->lien_url, '.pptx') !== false)
                              <a href="{{ route('support.showPdf', ['id' => $support->id_support]) }}" class="text-blue-600">
                                <i class="fas fa-download"></i> 
                            </a>
                        @elseif (strpos($support->lien_url, 'youtube.com') !== false || strpos($support->lien_url, 'youtu.be') !== false)
                            <a href="{{ $support->lien_url }}" target="_blank" class="text-red-600">
                                <i class="fab fa-youtube"></i> 
                            </a>
                        @else
                            <a href="{{ $support->lien_url }}" target="_blank" class="text-indigo-600">
                                <i class="fa-solid fa-folder"></i> 
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

</div>





{{-- Dernières questions posées --}}
<div class="mt-10 max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg border border-gray-200">
    <h2 class="text-2xl font-semibold text-indigo-900 mb-4">Dernières questions posées dans vos matières</h2>

    @if ($dernieresQuestions->isEmpty())
        <p class="text-gray-500">Aucune question posée récemment.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach ($dernieresQuestions as $question)
                <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-indigo-800">{{ $question->titre }}</h3>
                        <p class="text-sm text-gray-600">
                            Publiée le {{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y à H:i') }} |
                            Par : {{ $question->user->prenom ?? 'Utilisateur' }} {{ $question->user->nom ?? '' }} |
                            Matière : {{ $question->matiere->Nom ?? 'Non spécifiée' }}
                        </p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <a href="{{ route('professeur.questions.show', ['id' => $question->id_question]) }}" class="text-blue-600" title="Voir la question">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
