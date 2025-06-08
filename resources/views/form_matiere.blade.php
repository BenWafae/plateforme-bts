@extends('layouts.admin')

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
            font-size: 0.875rem;
            color: #ef4444;
            margin-top: 4px;
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

        .btn-secondary-custom {
            background: white;
            border: 2px solid #e5e7eb;
            color: #6b7280;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-secondary-custom:hover {
            border-color: #5E60CE;
            color: #5E60CE;
            background-color: rgba(94, 96, 206, 0.05);
            text-decoration: none;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .mt-4 {
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

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .input-group {
            position: relative;
        }

        .required-asterisk {
            color: #ef4444;
            margin-left: 2px;
        }
    </style>

    <div class="container mx-auto px-6 py-12">
        <div class="container-custom">
            <!-- En-tête de la page -->
            <div class="page-header">
                <div class="form-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h1 class="page-title">Ajouter une matière</h1>
                <p class="page-subtitle">Créez une nouvelle matière pour votre programme académique</p>
            </div>

            <!-- Formulaire -->
            <div class="form-container p-8">
                <form action="{{ route('matiere.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="Nom" class="form-label">
                            Nom de la matière <span class="required-asterisk">*</span>
                        </label>
                        <input type="text" id="Nom" name="Nom" value="{{ old('Nom') }}" class="form-control" required placeholder="Entrez le nom de la matière">
                        @error('Nom')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Décrivez brièvement cette matière...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_filiere" class="form-label">
                            Filière <span class="required-asterisk">*</span>
                        </label>
                        <select id="id_filiere" name="id_filiere" class="form-select" required>
                            <option value="" disabled selected>Sélectionnez une filière</option>
                            @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id_filiere }}" {{ old('id_filiere') == $filiere->id_filiere ? 'selected' : '' }}>
                                {{ $filiere->nom_filiere }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_filiere')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_user" class="form-label">
                            Professeur <span class="required-asterisk">*</span>
                        </label>
                        <select id="id_user" name="id_user" class="form-select" required>
                            <option value="" disabled selected>Sélectionnez un professeur</option>
                            @foreach($professeurs as $prof)
                            <option value="{{ $prof->id_user }}" {{ old('id_user') == $prof->id_user ? 'selected' : '' }}>
                                {{ $prof->nom }} {{ $prof->prenom }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary-custom mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 inline mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter la matière
                    </button>
                </form>

                <div class="mt-4">
                    <a href="{{ route('filiere.index') }}" class="btn-secondary-custom">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 inline mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux filières
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection



