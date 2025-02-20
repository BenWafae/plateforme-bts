@extends('layouts.professeur')

@section('content')
    <div class="container">
        <h1 class="my-4">Liste des Supports Éducatifs</h1>

        {{-- Affichage du message de succès --}}
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

        {{-- Parcourir chaque matière et afficher les supports associés --}}
        @foreach ($supportsParMatiere as $matiereId => $supports)
            {{-- Récupérer le nom de la matière --}}
            @php
                $matiere = $matieres->firstWhere('id_Matiere', $matiereId);
                // ici on cherche  le noom de laa matiere correspondant a l'id_Matiere recuperer
            @endphp
              <!-- Afficher le nom de la matière -->
            <h3 class="mt-4">{{ $matiere->Nom }}</h3>
        
            <div class="row">
                @foreach ($supports as $support)
                {{-- afficher les supports de la matieree apres le regroupement par matiere --}}
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $support->titre }}</h5>
                                <p class="card-text">{{ $support->description }}</p>

                                <a href="{{ $support->format === 'pdf' ? asset('storage/' . $support->lien_url) : asset('storage/' . $support->lien_url) }}"
                                    class="btn btn-{{ $support->format === 'pdf' ? 'primary' : 'success' }}"
                                    target="{{ $support->format === 'pdf' ? '_blank' : '_self' }}"
                                    @if ($support->format !== 'pdf') download @endif>
                                    {{ $support->format === 'pdf' ? 'Ouvrir le document' : 'Télécharger le document' }}
                                </a>

                                {{-- Bouton modifier --}}
                                <a href="{{ route('supports.edit', $support->id_support) }}" class="btn btn-warning btn-sm"
                                    title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Bouton suppression --}}
                                <form action="{{ route('supports.destroy', $support->id_support) }}" method="POST"
                                    class="d-inline-block ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?')"
                                        title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
