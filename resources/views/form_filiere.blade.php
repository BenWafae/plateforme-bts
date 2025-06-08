@extends('layouts.admin')

@section('title', 'Formulaire Filière')

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

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            color: #374151;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            outline: none;
            border-color: #5E60CE;
            box-shadow: 0 0 0 3px rgba(94, 96, 206, 0.1);
        }

        .form-control:hover {
            border-color: #9ca3af;
        }

        /* Style pour les alertes */
        .alert-success-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            border: none;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 12px 16px;
            border-radius: 6px;
            border: none;
            margin-top: 8px;
            font-size: 0.875rem;
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
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
            max-width: 600px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .required-asterisk {
            color: #ef4444;
            margin-left: 2px;
        }

        /* Animation pour les alertes */
        .alert-success-custom {
            animation: slideInFromTop 0.5s ease-out;
        }

        @keyframes slideInFromTop {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            display: inline-flex;
            align-items: center;
            margin-right: 8px;
        }
    </style>

    <div class="container mx-auto px-6 py-12">
        <div class="container-custom">
            <!-- En-tête de la page -->
            <div class="page-header">
                <div class="form-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H5m14 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m6 0V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v12" />
                    </svg>
                </div>
                <h2 class="page-title">Créer une nouvelle Filière</h2>
                <p class="page-subtitle">Ajoutez une nouvelle filière à votre programme académique</p>
            </div>

            <!-- Affichage du message de succès -->
            @if (session('success'))
                <div class="alert-success-custom">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire -->
            <div class="form-container p-8">
                <!-- Formulaire de création de filière -->
                <form action="{{ route('filiere.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nom_filiere" class="form-label">
                            Nom de la Filière <span class="required-asterisk">*</span>
                        </label>
                        <input type="text" 
                               id="nom_filiere" 
                               name="nom_filiere" 
                               class="form-control" 
                               placeholder="Entrez le nom de la filière" 
                               value="{{ old('nom_filiere') }}"
                               required>
                        
                        <!-- Afficher l'erreur -->
                        @error('nom_filiere')
                            <div class="alert-danger-custom">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 inline mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-primary-custom mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 inline mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter la Filière
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
