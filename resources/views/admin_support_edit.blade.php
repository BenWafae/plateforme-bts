@extends('layouts.admin')

@section('title', 'Modifier un Support Éducatif')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white text-center">
            <h3>Modifier un Support Éducatif</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.support.update', $support->id_support) }}" method="POST" enctype="multipart/form-data">
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

                <div class="mb-3">
                    <label for="format" class="form-label">Format :</label>
                    <select name="format" class="form-select" required>
                        <option value="pdf" {{ $support->format == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="ppt" {{ $support->format == 'ppt' ? 'selected' : '' }}>PPT</option>
                        <option value="word" {{ $support->format == 'word' ? 'selected' : '' }}>Word</option>
                        <option value="lien_video" {{ $support->format == 'lien_video' ? 'selected' : '' }}>Lien Vidéo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lien_url" class="form-label">Fichier actuel :</label>
                    <p>
                        <a href="{{ asset('storage/' . $support->lien_url) }}" target="_blank" class="btn btn-outline-primary">
                            📂 Voir le fichier
                        </a>
                    </p>
                    <label for="lien_url" class="form-label">Télécharger un nouveau fichier :</label>
                    <input type="file" name="lien_url" class="form-control" accept=".pdf,.docx,.pptx,.jpg,.png">
                </div>

                <div class="mb-3">
                    <label for="id_Matiere" class="form-label">Matière :</label>
                    <select class="form-select" name="id_Matiere" required>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_Matiere }}" {{ $support->id_Matiere == $matiere->id_Matiere ? 'selected' : '' }}>
                                {{ $matiere->Nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_type" class="form-label">Type :</label>
                    <select name="id_type" class="form-select" required>
                        @foreach($types as $type)
                            <option value="{{ $type->id_type }}" {{ $support->id_type == $type->id_type ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_user" class="form-label">Professeur :</label>
                    <select name="id_user" class="form-select" required>
                        @foreach($professeurs  as $professeur)
                            <option value="{{ $professeur->id_user }}" {{ $support->id_user == $professeur->id_user ? 'selected' : '' }}>
                                {{ $professeur->nom }} {{ $professeur->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning w-100">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
