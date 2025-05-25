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
            <form action="{{ route('supports.store') }}" method="POST" enctype="multipart/form-data">
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

                <!-- Champ pour l'upload de fichier -->
                <div class="mb-3" id="fileUploadDiv">
                    <label for="lien_url" class="form-label">Télécharger le fichier :</label>
                    <input type="file" name="lien_url" class="form-control" accept=".pdf,.docx,.pptx,.jpg,.png">
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

                <div class="form-group">
    <label for="prive">Privé ?</label>
    <input type="checkbox" id="prive" name="prive" value="1" {{ old('prive', isset($support) ? $support->prive : false) ? 'checked' : '' }}>
    @error('prive')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<a href="{{ route('professeur.support.form') }}" 
   style="
       display: inline-block;
       background-color: #1565c0; 
       color: white; 
       padding: 10px 20px; 
       border-radius: 6px; 
       font-weight: 700; 
       text-decoration: none; 
       box-shadow: 0 3px 8px rgba(21, 101, 192, 0.5);
       transition: background-color 0.3s ease;
   "
   onmouseover="this.style.backgroundColor='#0d3c78';"
   onmouseout="this.style.backgroundColor='#1565c0';"
>
    Importer plusieurs supports via IA
</a>




{{-- JavaScript pour afficher ou masquer dynamiquement les champs --}}
<script>
    function toggleInputFields() {
        let format = document.getElementById("format").value;
        let fileUploadDiv = document.getElementById("fileUploadDiv");
        let videoLinkDiv = document.getElementById("videoLinkDiv");

        if (format === "lien_video") {
            fileUploadDiv.style.display = "none";
            videoLinkDiv.style.display = "block";
        } else {
            fileUploadDiv.style.display = "block";
            videoLinkDiv.style.display = "none";
        }
    }
</script>
@endsection
