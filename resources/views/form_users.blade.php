@extends('layouts.admin')

@section('title', 'Ajouter un utilisateur')

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
        .from-violet-custom {
            --tw-gradient-from: #5E60CE;
            --tw-gradient-to: rgba(94, 96, 206, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
        .to-violet-custom {
            --tw-gradient-to: #5E60CE;
        }

        /* Styles pour le formulaire */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-top: 4px solid #5E60CE;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            color: #374151;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #5E60CE;
            box-shadow: 0 0 0 3px rgba(94, 96, 206, 0.1);
        }

        .form-control:hover, .form-select:hover {
            border-color: #9ca3af;
        }

        .text-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            margin-top: 8px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #5E60CE 0%, #7c3aed 100%);
            border: none;
            color: white;
            padding: 14px 24px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(94, 96, 206, 0.3);
            background: linear-gradient(135deg, #4F50AD 0%, #6d28d9 100%);
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .form-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #5E60CE 0%, #7c3aed 100%);
            border-radius: 12px;
            margin: 0 auto 1rem;
        }

        .container-custom {
            max-width: 700px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .required-asterisk {
            color: #ef4444;
            margin-left: 2px;
        }

        /* Style spécifique pour le select de rôle */
        .role-select {
            position: relative;
        }

        .role-option {
            padding: 12px 16px;
        }

        /* Icônes pour les différents champs */
        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .form-control.with-icon {
            padding-right: 45px;
        }

        /* Grid pour organiser les champs */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animation pour les erreurs */
        .text-danger {
            animation: slideInFromLeft 0.3s ease-out;
        }

        @keyframes slideInFromLeft {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <div class="container mx-auto px-6 py-12">
        <div class="container-custom">
            <!-- En-tête de la page -->
            <div class="page-header">
                <div class="form-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="page-title">Ajouter un utilisateur</h2>
                <p class="page-subtitle">Créez un nouveau compte utilisateur pour votre plateforme</p>
            </div>

            <!-- Formulaire -->
            <div class="form-container p-8">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nom et Prénom sur la même ligne -->
                    <div class="form-grid">
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                Nom <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-with-icon">
                                <input type="text" 
                                       class="form-control with-icon" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}"
                                       placeholder="Nom de famille"
                                       required>
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('nom')
                                <div class="text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">
                                Prénom <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-with-icon">
                                <input type="text" 
                                       class="form-control with-icon" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="{{ old('prenom') }}"
                                       placeholder="Prénom"
                                       required>
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('prenom')
                                <div class="text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email <span class="required-asterisk">*</span>
                        </label>
                        <div class="input-with-icon">
                            <input type="email" 
                                   class="form-control with-icon" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="exemple@email.com"
                                   required>
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                        @error('email')
                            <div class="text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Mot de passe <span class="required-asterisk">*</span>
                        </label>
                        <div class="input-with-icon">
                            <input type="password" 
                                   class="form-control with-icon" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Mot de passe sécurisé"
                                   required>
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <div class="text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">
                            Rôle <span class="required-asterisk">*</span>
                        </label>
                        <div class="role-select">
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled selected>Sélectionnez un rôle</option>
                                <option value="administrateur" {{ old('role') == 'administrateur' ? 'selected' : '' }}>
                                    👑 Administrateur
                                </option>
                                <option value="professeur" {{ old('role') == 'professeur' ? 'selected' : '' }}>
                                    👨‍🏫 Professeur
                                </option>
                                <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>
                                    🎓 Étudiant
                                </option>
                            </select>
                        </div>
                        @error('role')
                            <div class="text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 inline mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Ajouter l'utilisateur
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection