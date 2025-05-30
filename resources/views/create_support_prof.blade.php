@extends('layouts.professeur')

@section('title', 'Ajouter un Support Éducatif')

@section('content')
<div class="container-fluid mt-4">
    <!-- En-tête de la page -->
    <div class="page-header mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="page-title mb-1">
                    <i class="fas fa-plus-circle text-primary me-2"></i>
                    Ajouter un Support Éducatif
                </h2>
                <p class="page-subtitle text-muted">Créez et partagez du contenu pédagogique avec vos étudiants</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('supports.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Messages d'erreur -->
    @if ($errors->any())
        <div class="alert alert-danger alert-modern mb-4">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-body">
                    <h6 class="alert-title mb-2">Erreurs de validation</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulaire principal -->
    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <form action="{{ route('supports.store') }}" method="POST" enctype="multipart/form-data" class="modern-form">
                    @csrf
                    
                    <!-- Section 1: Informations générales -->
                    <div class="form-section">
                        <div class="section-header">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle section-icon"></i>
                                Informations générales
                            </h5>
                            <p class="section-subtitle">Définissez les informations de base du support</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group-modern">
                                    <label for="titre" class="form-label-modern">
                                        <i class="fas fa-heading me-2"></i>
                                        Titre du support
                                    </label>
                                    <input type="text" 
                                           name="titre" 
                                           id="titre"
                                           class="form-control-modern" 
                                           placeholder="Ex: Introduction aux bases de données"
                                           value="{{ old('titre') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label for="format" class="form-label-modern">
                                        <i class="fas fa-file-alt me-2"></i>
                                        Format
                                    </label>
                                    <select name="format" 
                                            id="format" 
                                            class="form-select-modern" 
                                            required 
                                            onchange="toggleInputFields()">
                                        <option value="" disabled selected>Choisir le format</option>
                                        <option value="pdf" {{ old('format') == 'pdf' ? 'selected' : '' }}>
                                            Document PDF
                                        </option>
                                        <option value="ppt" {{ old('format') == 'ppt' ? 'selected' : '' }}>
                                            Présentation PPT
                                        </option>
                                        <option value="word" {{ old('format') == 'word' ? 'selected' : '' }}>
                                            Document Word
                                        </option>
                                        <option value="lien_video" {{ old('format') == 'lien_video' ? 'selected' : '' }}>
                                            Lien Vidéo
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-modern">
                            <label for="description" class="form-label-modern">
                                <i class="fas fa-align-left me-2"></i>
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      class="form-control-modern" 
                                      rows="4" 
                                      placeholder="Décrivez le contenu et les objectifs de ce support..."
                                      required>{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Section 2: Fichier ou lien -->
                    <div class="form-section">
                        <div class="section-header">
                            <h5 class="section-title">
                                <i class="fas fa-upload section-icon"></i>
                                Contenu du support
                            </h5>
                            <p class="section-subtitle">Ajoutez le fichier ou le lien de votre support</p>
                        </div>
                        
                        <!-- Zone de téléchargement de fichier -->
                        <div class="form-group-modern" id="fileUploadDiv">
                            <label class="form-label-modern">
                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                Télécharger le fichier
                            </label>
                            <div class="file-upload-zone">
                                <input type="file" 
                                       name="lien_url" 
                                       id="lien_url"
                                       class="file-input" 
                                       accept=".pdf,.docx,.pptx,.jpg,.png">
                                <div class="file-upload-content">
                                    <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                    <p class="file-upload-text">
                                        <strong>Cliquez pour sélectionner</strong> ou glissez-déposez votre fichier
                                    </p>
                                    <p class="file-upload-hint">PDF, Word, PowerPoint, JPG, PNG (Max: 10MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Zone de lien vidéo -->
                        <div class="form-group-modern" id="videoLinkDiv" style="display: none;">
                            <label for="video_url" class="form-label-modern">
                                <i class="fas fa-link me-2"></i>
                                Lien de la vidéo
                            </label>
                            <input type="url" 
                                   name="video_url" 
                                   id="video_url"
                                   class="form-control-modern" 
                                   value="{{ old('video_url') }}"
                                   placeholder="https://www.youtube.com/watch?v=xyz">
                            <div class="form-hint">
                                <i class="fas fa-info-circle me-1"></i>
                                Formats supportés: YouTube, Vimeo, liens directs
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Classification -->
                    <div class="form-section">
                        <div class="section-header">
                            <h5 class="section-title">
                                <i class="fas fa-tags section-icon"></i>
                                Classification
                            </h5>
                            <p class="section-subtitle">Organisez votre support dans la bonne catégorie</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="id_Matiere" class="form-label-modern">
                                        <i class="fas fa-book me-2"></i>
                                        Matière
                                    </label>
                                    <select class="form-select-modern" 
                                            id="id_Matiere" 
                                            name="id_Matiere" 
                                            required>
                                        <option value="">Sélectionner une matière</option>
                                        @foreach($matieres as $matiere)
                                            <option value="{{ $matiere->id_Matiere }}" {{ old('id_Matiere') == $matiere->id_Matiere ? 'selected' : '' }}>
                                                {{ $matiere->Nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="id_type" class="form-label-modern">
                                        <i class="fas fa-layer-group me-2"></i>
                                        Type de support
                                    </label>
                                    <select name="id_type" 
                                            class="form-select-modern" 
                                            required>
                                        <option value="" disabled selected>Choisir le type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id_type }}" {{ old('id_type') == $type->id_type ? 'selected' : '' }}>
                                                {{ $type->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-lock me-2"></i>
                                        Visibilité
                                    </label>
                                    <div class="toggle-switch-container">
                                        <label class="toggle-switch">
                                            <input type="checkbox" 
                                                   id="prive" 
                                                   name="prive" 
                                                   value="1" 
                                                   {{ old('prive', isset($support) ? $support->prive : false) ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                        <span class="toggle-label">Support privé</span>
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Les supports privés ne sont visibles que par vous
                                    </div>
                                    @error('prive')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="action-info">
                                <i class="fas fa-info-circle text-muted me-2"></i>
                                <span class="text-muted">Tous les champs marqués d'un * sont obligatoires</span>
                            </div>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-secondary me-2" onclick="history.back()">
                                    <i class="fas fa-times me-1"></i>
                                    Annuler
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>
                                    Créer le support
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bouton IA séparé avec style moderne -->
    <div class="ai-import-section mt-4">
        <div class="ai-card">
            <div class="ai-content">
                <div class="ai-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="ai-text">
                    <h5 class="ai-title">Import intelligent</h5>
                    <p class="ai-description">Utilisez l'IA pour importer et traiter plusieurs supports en une seule fois</p>
                </div>
                <div class="ai-action">
                    <a href="{{ route('professeur.support.form') }}" class="btn btn-ai">
                        <i class="fas fa-brain me-2"></i>
                        Importer avec IA
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variables CSS pour cohérence avec le thème */
:root {
    --primary-color: #5E60CE;
    --primary-light: rgba(94, 96, 206, 0.1);
    --primary-hover: #4c4eb8;
    --secondary-color: #6B7280;
    --success-color: #10B981;
    --danger-color: #EF4444;
    --warning-color: #F59E0B;
    --ai-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --light-bg: #F9FAFB;
    --white: #FFFFFF;
    --border-color: #E5E7EB;
    --text-primary: #111827;
    --text-secondary: #6B7280;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
}

/* En-tête de page */
.page-header {
    background: linear-gradient(135deg, var(--white) 0%, var(--light-bg) 100%);
    padding: 2rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.page-title {
    color: var(--text-primary);
    font-weight: 700;
    font-size: 1.75rem;
}

.page-subtitle {
    font-size: 1rem;
    margin: 0;
}

.page-actions .btn {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

/* Carte de formulaire */
.form-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

/* Sections du formulaire */
.form-section {
    padding: 2.5rem;
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-child {
    border-bottom: none;
}

.section-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-light);
}

.section-title {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1.25rem;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
}

.section-icon {
    color: var(--primary-color);
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

.section-subtitle {
    color: var(--text-secondary);
    margin: 0;
    font-size: 0.95rem;
}

/* Groupes de formulaire */
.form-group-modern {
    margin-bottom: 2rem;
}

.form-label-modern {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-control-modern,
.form-select-modern {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 1rem;
    transition: all 0.2s ease;
    background-color: var(--white);
}

.form-control-modern:focus,
.form-select-modern:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
    transform: translateY(-1px);
}

.form-control-modern::placeholder {
    color: var(--text-secondary);
}

/* Zone de téléchargement de fichier */
.file-upload-zone {
    position: relative;
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-lg);
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, var(--white) 0%, var(--light-bg) 100%);
    cursor: pointer;
}

.file-upload-zone:hover {
    border-color: var(--primary-color);
    background: var(--primary-light);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.file-upload-text {
    font-size: 1.1rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.file-upload-hint {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

/* Toggle switch */
.toggle-switch-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--border-color);
    transition: 0.3s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: var(--shadow-sm);
}

input:checked + .toggle-slider {
    background-color: var(--primary-color);
}

input:checked + .toggle-slider:before {
    transform: translateX(26px);
}

.toggle-label {
    font-weight: 500;
    color: var(--text-primary);
}

/* Conseils et indices */
.form-hint {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
}

/* Alertes modernes */
.alert-modern {
    border: none;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

.alert-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert-icon {
    font-size: 1.25rem;
    margin-top: 0.25rem;
}

.alert-title {
    font-weight: 600;
    margin: 0;
}

.alert-danger {
    background: linear-gradient(135deg, #FEF2F2 0%, #FECACA 100%);
    color: var(--danger-color);
    border-left: 4px solid var(--danger-color);
}

/* Actions du formulaire */
.form-actions {
    padding: 2rem 2.5rem;
    background: var(--light-bg);
    border-top: 1px solid var(--border-color);
}

.action-info {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

/* Section IA */
.ai-import-section {
    margin-top: 2rem;
}

.ai-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 2px solid transparent;
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
}

.ai-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: rgba(102, 126, 234, 0.3);
}

.ai-content {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.ai-icon {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    background: var(--ai-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: var(--shadow-md);
}

.ai-text {
    flex: 1;
}

.ai-title {
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    font-size: 1.2rem;
}

.ai-description {
    color: var(--text-secondary);
    margin: 0;
    font-size: 0.95rem;
}

.ai-action {
    flex-shrink: 0;
}

.btn-ai {
    background: var(--ai-gradient);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius-md);
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-ai:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
    color: white;
}

/* Boutons */
.btn {
    border-radius: var(--radius-md);
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.2s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
    color: white;
    box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
    background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-color) 100%);
    color: white;
}

.btn-secondary {
    background: var(--white);
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--light-bg);
    border-color: var(--text-secondary);
    color: var(--text-primary);
}

.btn-outline-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
}

.btn-outline-secondary:hover {
    background: var(--light-bg);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

/* Animation et transitions */
.modern-form {
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animation pour les sections */
.form-section {
    animation: slideInUp 0.4s ease-out;
    animation-fill-mode: both;
}

.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .form-actions {
        padding: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .action-info {
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .file-upload-zone {
        padding: 2rem 1rem;
    }
    
    .file-upload-icon {
        font-size: 2rem;
    }
    
    .ai-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .ai-text {
        order: 2;
    }
    
    .ai-action {
        order: 3;
    }
}
</style>

<script>
function toggleInputFields() {
    let format = document.getElementById("format").value;
    let fileUploadDiv = document.getElementById("fileUploadDiv");
    let fileInput = fileUploadDiv.querySelector('input[type="file"]');
    let videoLinkDiv = document.getElementById("videoLinkDiv");

    if (format === "lien_video") {
        fileUploadDiv.style.display = "none";
        fileInput.disabled = true;
        fileInput.required = false;
        videoLinkDiv.style.display = "block";
        document.getElementById("video_url").required = true;
    } else {
        fileUploadDiv.style.display = "block";
        fileInput.disabled = false;
        fileInput.required = true;
        videoLinkDiv.style.display = "none";
        document.getElementById("video_url").required = false;
    }
}

// Animation de la zone de fichier au survol
document.addEventListener('DOMContentLoaded', function() {
    const fileUploadZone = document.querySelector('.file-upload-zone');
    const fileInput = document.querySelector('.file-input');
    
    if (fileUploadZone && fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const fileUploadContent = fileUploadZone.querySelector('.file-upload-content');
                fileUploadContent.innerHTML = `
                    <i class="fas fa-file-check file-upload-icon" style="color: var(--success-color);"></i>
                    <p class="file-upload-text">
                        <strong>Fichier sélectionné:</strong><br>
                        ${fileName}
                    </p>
                    <p class="file-upload-hint">Cliquez pour changer de fichier</p>
                `;
                fileUploadZone.style.borderColor = 'var(--success-color)';
                fileUploadZone.style.background = 'rgba(16, 185, 129, 0.05)';
            }
        });
    }
    
    // Animation pour les champs de formulaire
    const formInputs = document.querySelectorAll('.form-control-modern, .form-select-modern');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Appel initial pour définir l'état correct des champs
    toggleInputFields();
});
</script>
@endsection