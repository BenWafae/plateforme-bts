@extends('layouts.professeur')

@section('content')
    <div class="container">
        <h2>Mes Supports de Cours</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @foreach ($matieres as $matiere)
            @php
                $supportsParType = $supportsParMatiereEtType->filter(function ($supports, $key) use ($matiere) {
                    return Str::startsWith($key, $matiere->id_Matiere . '-');
                });
            @endphp

            @if ($supportsParType->isNotEmpty())
                <div class="card mt-5"> 
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">{{ $matiere->Nom }}</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($types as $type)
                            @php
                                $supports = $supportsParType->get(
                                    $matiere->id_Matiere . '-' . $type->id_type,
                                    collect()
                                );
                                $typeStyles = [
                                            'cours' => ['bg-primary', 'Cours'],
                                            'exercice' => ['bg-warning', 'Exercices'],
                                            'examens' => ['bg-danger', 'Examens'],
];

                                $typeKey = strtolower($type->nom);
                                $badgeClass = $typeStyles[$typeKey][0] ?? 'bg-secondary';
                            @endphp
                              {{-- iciii j'ai filtrerr les supports pour ne garder que ceeeux qui appartient a la matiere 
                    $supportparmatieretype : est une collection contenant les support clasee par matiere et type
                    Str::startsWith($key, $matiere->id_Matiere . '-' :ici on verifier siii  la cle de support commence par lid de la matiere actuel --}}


                            @if ($supports->isNotEmpty())
                                <h4 class="mt-2 mb-1 p-2 text-white {{ $badgeClass }} rounded">{{ $type->nom }}</h4>
                                <div class="row mt-2 mb-2 gy-3">  
                                    @foreach ($supports as $support)
                                        <div class="col-md-4">
                                            <div class="card mb-3 shadow-sm h-100 d-flex flex-column"> 
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title">{{ $support->titre }}</h5>
                                                    <p class="card-text flex-grow-1">{{ $support->description }}</p>
                                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                                        <a href="{{ asset('storage/' . $support->lien_url) }}"
                                                            class="btn btn-sm {{ $support->format === 'pdf' ? 'btn-outline-primary' : 'btn-outline-success' }}"
                                                            target="{{ $support->format === 'pdf' ? '_blank' : '_self' }}"
                                                            @if ($support->format !== 'pdf') download @endif>
                                                            @if ($support->format === 'pdf')
                                                                📄 Ouvrir
                                                            @else
                                                                ⬇ Télécharger
                                                            @endif
                                                        </a>

                                                        <a href="{{ route('supports.edit', $support->id_support) }}" 
                                                            class="btn btn-sm btn-outline-warning" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('supports.destroy', $support->id_support) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?')" 
                                                                title="Supprimer">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    @endforeach
                                </div> 
                            @endif
                        @endforeach
                    </div>
                </div> 
            @endif
        @endforeach
    </div>
@endsection






