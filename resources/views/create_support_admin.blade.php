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

                <div class="mb-3" id="videoLinkDiv" style="display: none;">
                    <label for="video_url" class="form-label">Lien Vidéo :</label>
                    <input type="url" name="video_url" class="form-control" placeholder="Ex: https://www.youtube.com/watch?v=xyz">
                </div>

                <div class="form-group">
                    <label for="id_Matiere">Matière</label>
                    <select class="form-control" id="id_Matiere" name="id_Matiere" required onchange="filterProfesseurs()">
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_Matiere }}">{{ $matiere->Nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 mt-3">
                    <label for="id_user" class="form-label">Professeur :</label>
                    <select name="id_user" class="form-select" id="id_user" required>
                        <option value="" disabled selected>Choisir un professeur</option>
                        @foreach($professeurs as $prof)
                            <option value="{{ $prof->id_user }}">{{ $prof->nom }} {{ $prof->prenom }}</option>
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

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function toggleInputFields() {
        let format = document.getElementById("format").value;
        let fileUploadDiv = document.getElementById("fileUploadDiv");
        let fileInput = fileUploadDiv.querySelector('input[type="file"]');
        let videoLinkDiv = document.getElementById("videoLinkDiv");

        if (format === "lien_video") {
            fileUploadDiv.style.display = "none";
            fileInput.disabled = true;
            videoLinkDiv.style.display = "block";
        } else {
            fileUploadDiv.style.display = "block";
            fileInput.disabled = false;
            videoLinkDiv.style.display = "none";
        }
    }
   // partie professeur 

    function filterProfesseurs() {
        let selectedMatiereId = document.getElementById("id_Matiere").value;
        let professeurSelect = document.getElementById("id_user");
        let professeurs = @json($professeurs);

        professeurSelect.innerHTML = '';

        if (selectedMatiereId === "") {
            //Aucune matière sélectionnée → afficher tous les professeurs avec le placeholder
            let placeholder = document.createElement("option");
            placeholder.disabled = true;
            placeholder.selected = true;
            placeholder.textContent = "Choisir un professeur";
            professeurSelect.appendChild(placeholder);

            professeurs.forEach(professeur => {
                let option = document.createElement("option");
                option.value = professeur.id_user;
                option.textContent = professeur.nom + ' ' + professeur.prenom;
                professeurSelect.appendChild(option);
            });
        } else {
            // Afficher seulement le(s) prof(s) associé(s)
            let filtered = professeurs.filter(prof => {
                return prof.matieres.some(m => m.id_Matiere == selectedMatiereId);
            });

            filtered.forEach(professeur => {
                let option = document.createElement("option");
                option.value = professeur.id_user;
                option.textContent = professeur.nom + ' ' + professeur.prenom;
                professeurSelect.appendChild(option);
            });
        }
    }
</script>
@endsection








