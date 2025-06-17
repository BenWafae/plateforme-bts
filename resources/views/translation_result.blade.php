@extends('layouts.navbar')

@section('title', 'Résultat de traduction')

@section('content')
    <style>
        /* Configuration des couleurs personnalisées */
        .bg-violet-custom {
            background-color: #5E60CE;
        }
        .text-violet-custom {
            color: #5E60CE;
        }
        .border-violet-custom {
            border-color: #5E60CE;
        }
        .bg-violet-50 {
            background-color: rgba(94, 96, 206, 0.05);
        }
        .hover\:text-violet-700:hover {
            color: #4F50AD;
        }
        .hover\:bg-violet-50:hover {
            background-color: rgba(94, 96, 206, 0.05);
        }
        .from-violet-custom {
            --tw-gradient-from: #5E60CE;
            --tw-gradient-to: rgba(94, 96, 206, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-violet-custom {
            --tw-gradient-to: #5E60CE;
        }
        .btn-violet-custom {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            color: white;
            border: none;
            transition: all 0.3s ease;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-violet-custom:hover {
            background: linear-gradient(135deg, #4F50AD, #6B6DD9);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(94, 96, 206, 0.3);
        }
        .form-control-custom {
            border: 2px solid rgba(94, 96, 206, 0.2);
            border-radius: 8px;
            transition: all 0.3s ease;
            padding: 12px 16px;
            font-size: 0.95rem;
        }
        .form-control-custom:focus {
            border-color: #5E60CE;
            box-shadow: 0 0 0 0.2rem rgba(94, 96, 206, 0.25);
            outline: none;
        }
        .form-select-custom {
            border: 2px solid rgba(94, 96, 206, 0.2);
            border-radius: 8px;
            transition: all 0.3s ease;
            padding: 12px 16px;
            font-size: 0.95rem;
            background-color: white;
        }
        .form-select-custom:focus {
            border-color: #5E60CE;
            box-shadow: 0 0 0 0.2rem rgba(94, 96, 206, 0.25);
            outline: none;
        }
        .translation-container {
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.05), rgba(120, 121, 227, 0.02));
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(94, 96, 206, 0.1);
            border-top: 4px solid #5E60CE;
            margin-bottom: 2rem;
        }
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(94, 96, 206, 0.1);
            margin-bottom: 2rem;
        }
        .result-section {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), rgba(40, 167, 69, 0.02));
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-left: 4px solid #28a745;
        }
        .pdf-link-container {
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.1), rgba(120, 121, 227, 0.05));
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid rgba(94, 96, 206, 0.2);
            margin-bottom: 2rem;
        }
        .pdf-link {
            color: #5E60CE;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 6px;
        }
        .pdf-link:hover {
            color: white;
            background-color: #5E60CE;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(94, 96, 206, 0.3);
        }
        .alert-danger-custom {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
            border: 1px solid rgba(220, 53, 69, 0.2);
            border-left: 4px solid #dc3545;
            color: #721c24;
            border-radius: 8px;
            padding: 1rem 1.5rem;
        }
        .form-label-custom {
            color: #5E60CE;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }
        .page-title {
            background: linear-gradient(135deg, #5E60CE, #7879E3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        .icon-violet {
            color: #5E60CE;
        }
        
        /* Animation de chargement pour le bouton */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .translation-container {
                padding: 1.5rem;
            }
            .form-section {
                padding: 1.5rem;
            }
            .result-section {
                padding: 1.5rem;
            }
            .pdf-link-container {
                padding: 1rem;
            }
        }
    </style>

    <div class="container mx-auto px-4 py-8">
        <!-- Titre de la page -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold page-title mb-2 flex items-center justify-center">
                <i class="fas fa-language icon-violet mr-3"></i>
                Traduction de Support
            </h1>
            <p class="text-gray-600 text-lg">{{ $support->titre }}</p>
        </div>

        <div class="translation-container">
            <!-- Lien vers le PDF -->
            <div class="pdf-link-container">
                <div class="flex items-center">
                    <i class="fas fa-file-pdf icon-violet text-2xl mr-3"></i>
                    <div>
                        <h4 class="text-violet-custom font-semibold mb-1">Document Source</h4>
                        <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="pdf-link">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Ouvrir le document PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulaire de traduction -->
            <div class="form-section">
                <form action="{{ route('support.translate.process') }}" method="POST" id="translationForm">
                    @csrf
                    <input type="hidden" name="id_support" value="{{ $support->id_support }}">
                    
                    <!-- Zone de texte à traduire -->
                    <div class="mb-6">
                        <label for="text_to_translate" class="form-label-custom">
                            <i class="fas fa-edit mr-2"></i>
                            Texte à traduire
                        </label>
                        <textarea id="text_to_translate" 
                                  name="text_to_translate" 
                                  rows="8" 
                                  class="form-control form-control-custom w-full" 
                                  placeholder="Collez ici le texte que vous souhaitez traduire..." 
                                  required>{{ old('text_to_translate') }}</textarea>
                    </div>

                    <!-- Sélection de la langue -->
                    <div class="mb-6">
                        <label for="target_language" class="form-label-custom">
                            <i class="fas fa-globe mr-2"></i>
                            Langue de traduction
                        </label>
                        <select id="target_language" 
                                name="target_language" 
                                class="form-select form-select-custom w-full" 
                                required>
                            <option value="" disabled {{ old('target_language') ? '' : 'selected' }}>
                                -- Sélectionnez une langue de destination --
                            </option>
                            <option value="en" {{ old('target_language') == 'en' ? 'selected' : '' }}>
                                🇬🇧 Français vers Anglais
                            </option>
                            <option value="ar" {{ old('target_language') == 'ar' ? 'selected' : '' }}>
                                🇸🇦 Français vers Arabe
                            </option>
                        </select>
                    </div>

                    <!-- Bouton de traduction -->
                    <div class="text-center">
                        <button type="submit" 
                                class="btn btn-violet-custom" 
                                id="translateBtn">
                            <i class="fas fa-language mr-2"></i>
                            Traduire le texte
                        </button>
                    </div>
                </form>
            </div>

            <!-- Résultat de la traduction -->
            @isset($translated)
                <div class="result-section">
                    <div class="mb-4">
                        <h4 class="text-green-700 font-semibold flex items-center text-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Résultat de la traduction
                        </h4>
                    </div>
                    <div class="mb-4">
                        <label for="translated_text" class="form-label-custom text-green-700">
                            <i class="fas fa-language mr-2"></i>
                            Texte traduit
                        </label>
                        <textarea id="translated_text" 
                                  rows="8" 
                                  class="form-control form-control-custom w-full" 
                                  readonly 
                                  style="background-color: #f8f9fa; border-color: rgba(40, 167, 69, 0.3);">{{ $translated }}</textarea>
                    </div>
                    
                    <!-- Bouton pour copier le texte -->
                    <div class="text-center">
                        <button type="button" 
                                class="btn" 
                                style="background: linear-gradient(135deg, #28a745, #34ce57); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; transition: all 0.3s ease;"
                                onclick="copyToClipboard()"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(40, 167, 69, 0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-copy mr-2"></i>
                            Copier la traduction
                        </button>
                    </div>
                </div>
            @endisset

            <!-- Messages d'erreur -->
            @if($errors->any())
                <div class="alert-danger-custom">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        <div>
                            <strong>Erreur de traduction</strong>
                            <p class="mb-0 mt-1">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Animation du bouton lors de la soumission
        document.getElementById('translationForm').addEventListener('submit', function() {
            const btn = document.getElementById('translateBtn');
            btn.classList.add('btn-loading');
            btn.innerHTML = '<span style="opacity: 0;">Traduction en cours...</span>';
            btn.disabled = true;
        });

        // Fonction pour copier le texte traduit
        function copyToClipboard() {
            const textArea = document.getElementById('translated_text');
            textArea.select();
            textArea.setSelectionRange(0, 99999); // Pour les appareils mobiles
            
            try {
                document.execCommand('copy');
                // Feedback visuel
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check mr-2"></i>Copié !';
                btn.style.background = 'linear-gradient(135deg, #28a745, #34ce57)';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 2000);
            } catch (err) {
                console.error('Erreur lors de la copie:', err);
            }
        }

        // Animation smooth pour les focus des inputs
        document.querySelectorAll('.form-control-custom, .form-select-custom').forEach(element => {
            element.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            element.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>

@endsection

