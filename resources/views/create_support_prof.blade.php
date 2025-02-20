@extends('layouts.professeur')

@section('title', 'Ajouter un Support Éducatif')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
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
            <form action="{{ route('supports.store') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre :</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="format" class="form-label">Format :</label>
                    <select name="format" class="form-select" required>
                        <option value="" disabled selected>Choisir le format</option> <!-- Placeholder Format -->
                        <option value="pdf">PDF</option>
                        <option value="ppt">PPT</option>
                        <option value="word">Word</option>
                        <option value="lien_video">Lien Vidéo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="lien_url" class="form-label">Télécharger le fichier :</label>
                    <input type="file" name="lien_url" class="form-control" accept=".pdf,.docx,.pptx,.jpg,.png" required>
                </div>

                <div class="form-group">
                    <label for="id_Matiere">Matière</label>
                    <select class="form-control" id="id_Matiere" name="id_Matiere" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_Matiere }}" {{ old('id_Matiere') == $matiere->id_Matiere ? 'selected' : '' }}>
                                {{ $matiere->Nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_type" class="form-label">Type :</label>
                    <select name="id_type" class="form-select" required>
                        <option value="" disabled selected>Choisir le type</option> <!-- Placeholder Type -->
                        @foreach($types as $type)
                            <option value="{{ $type->id_type }}">{{ $type->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
