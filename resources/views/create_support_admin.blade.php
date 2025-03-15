@extends('layouts.admin')

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
            <form action="{{ route('admin.support.store') }}" method="POST" enctype="multipart/form-data">
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
                    <select name="format" id="format" class="form-select" required onchange="toggleInputFields()">
                        <option value="" disabled selected>Choisir le format</option>
                        <option value="pdf">PDF</option>
                        <option value="ppt">PPT</option>
                        <option value="word">Word</option>
                        <option value="lien_video">Lien Vidéo</option>
                    </select>
                </div>

                <div class="mb-3" id="fileUploadDiv">
                    <label for="lien_url" class="form-label">Télécharger le fichier :</label>
                    <input type="file" name="lien_url" class="form-control" accept=".pdf,.docx,.pptx,.jpg,.png" required>
                </div>

                {{-- Champ pour ajouter un lien vidéo --}}
                <div class="mb-3" id="videoLinkDiv" style="display: none;">
                    <label for="video_url" class="form-label">Lien Vidéo :</label>
                    <input type="url" name="video_url" class="form-control" placeholder="Ex: https://www.youtube.com/watch?v=xyz">
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
                        <option value="" disabled selected>Choisir le type</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id_type }}">{{ $type->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_user" class="form-label">Professeur :</label>
                    <select name="id_user" class="form-select" required>
                        <option value="" disabled selected>Choisir un professeur</option>
                        @foreach($professeurs as $professeur)
                            <option value="{{ $professeur->id_user }}">{{ $professeur->nom }} {{ $professeur->prenom }}</option>
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

{{-- Script pour afficher ou masquer dynamiquement les champs --}}
<script>
    function toggleInputFields() {
        let format = document.getElementById("format").value;
        let fileUploadDiv = document.getElementById("fileUploadDiv");
        let fileInput = fileUploadDiv.querySelector('input[type=\"file\"]');
        let videoLinkDiv = document.getElementById("videoLinkDiv");

        if (format === "lien_video") {
            fileUploadDiv.style.display = "none";  // Cacher le champ d'upload de fichier
            fileInput.disabled = true;              // Désactiver le champ de fichier pour éviter la validation 'required'
            videoLinkDiv.style.display = "block";    // Afficher le champ lien vidéo
        } else {
            fileUploadDiv.style.display = "block";   // Afficher le champ d'upload de fichier
            fileInput.disabled = false;              // Réactiver le champ de fichier
            videoLinkDiv.style.display = "none";       // Masquer le champ lien vidéo
        }
    }
</script>
@endsection



