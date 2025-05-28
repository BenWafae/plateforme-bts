@extends('layouts.cours_public')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Résultats de recherche</h1>

    @if(!empty($query))
        <p class="mb-4 text-gray-600 text-center">
            Résultats pour : <strong class="text-violet-custom">"{{ $query }}"</strong>
        </p>
    @endif

    @if($supports->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($supports as $support)
                @php
                    $format = strtolower($support->format ?? '');
                    $id = $support->id_support ?? $support->id;
                    $isVideoLink = isset($support->lien_url) && filter_var($support->lien_url, FILTER_VALIDATE_URL);
                @endphp

                <div class="bg-white rounded-xl shadow-md border-2 border-violet-500 p-4 hover:shadow-lg hover:ring-2 hover:ring-violet-300 transition">
                    <h2 class="text-lg font-semibold text-violet-custom">{{ $support->titre }}</h2>

                    <p class="text-sm text-gray-600 mt-2">
                        {{ $support->matiere->Nom ?? 'Matière non définie' }}
                    </p>

                    <div class="flex space-x-3 mt-4">
                        @if($id)
                            @if(strpos($format, 'pdf') !== false)
                                <a href="{{ route('fichiers.view', ['id' => $id]) }}" target="_blank"
                                   class="px-3 py-1.5 border border-red-500 text-red-500 rounded hover:bg-red-500 hover:text-white transition text-sm flex items-center gap-1">
                                    <i class="fas fa-file-pdf"></i> Voir
                                </a>
                            @elseif(strpos($format, 'ppt') !== false || strpos($format, 'powerpoint') !== false || strpos($format, 'doc') !== false || strpos($format, 'word') !== false)
                                <a href="{{ route('fichiers.download', ['id' => $id]) }}"
                                   class="px-3 py-1.5 border border-blue-500 text-blue-500 rounded hover:bg-blue-500 hover:text-white transition text-sm flex items-center gap-1">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            @elseif(strpos($format, 'video') !== false && $isVideoLink)
                                <a href="{{ $support->lien_url }}" target="_blank"
                                   class="px-3 py-1.5 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-600 hover:text-white transition text-sm flex items-center gap-1">
                                    <i class="fab fa-youtube"></i> Regarder
                                </a>
                            @endif
                        @else
                            <p class="text-red-500 text-sm">ID manquant pour ce support</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $supports->withQueryString()->links() }}
        </div>
    @else
        <p class="text-gray-500 text-center">Aucun résultat trouvé.</p>
    @endif
</div>
@endsection
