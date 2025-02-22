@extends('layouts.professeur')

@section('title', 'Ajouter un Support Éducatif')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning  text-white text-center">
            <h3>Ajouter un Support Éducatif</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('supports.update', $support->id_support) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre :</label>
                    <input type="text" name="titre" class="form-control" value="{{ $support->titre }}" required>

                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ $support->description }}</textarea>

                </div>

                <select name="format" class="form-select" required>
                    <option value="" disabled>Choisir le format</option>
                    <option value="pdf" {{ $support->format == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="ppt" {{ $support->format == 'ppt' ? 'selected' : '' }}>PPT</option>
                    <option value="word" {{ $support->format == 'word' ? 'selected' : '' }}>Word</option>
                    <option value="lien_video" {{ $support->format == 'lien_video' ? 'selected' : '' }}>Lien Vidéo</option>
                </select>
                

                <div class="mb-3">
                    <label for="lien_url" class="form-label">Fichier actuel :</label>
                    <p>
                    <a href="{{ asset('storage/' . $support->lien_url) }}" target="_blank" class="btn btn-outline-primary">
                        📂 Voir le fichier
                    </a>
                </p>
                    {{-- <label for="lien_url" class="form-label">Télécharger le fichier :</label> --}}
                    <input type="file" name="lien_url" class="form-control" accept=".pdf,.docx,.pptx,.jpg,.png" required>
                </div>

                <select class="form-control" id="id_Matiere" name="id_Matiere" required>
                    <option value="">Sélectionner une matière</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id_Matiere }}" {{ $support->id_Matiere == $matiere->id_Matiere ? 'selected' : '' }}>
                            {{ $matiere->Nom }}
                        </option>
                    @endforeach
                </select>
                

                <div class="mb-3">
                    <label for="id_type" class="form-label">Type :</label>
                    <select name="id_type" class="form-select" required>
                        <option value="" disabled>Choisir le type</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id_type }}" {{ $support->id_type == $type->id_type ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning w-100">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection