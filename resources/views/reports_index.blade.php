@extends('layouts.admin')

@section('title', 'Gestion des Signalements')  

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
        
        /* Styles pour les badges */
        .badge-nouveau {
            background: linear-gradient(135deg, rgba(94, 96, 206, 0.1), rgba(94, 96, 206, 0.2));
            color: #5E60CE;
            border: 1px solid rgba(94, 96, 206, 0.3);
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .badge-en-cours {
            background: linear-gradient(135deg, rgba(168, 162, 158, 0.1), rgba(168, 162, 158, 0.2));
            color: #A8A29E;
            border: 1px solid rgba(168, 162, 158, 0.3);
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .badge-resolu {
            background: linear-gradient(135deg, rgba(139, 125, 161, 0.1), rgba(139, 125, 161, 0.2));
            color: #8B7DA1;
            border: 1px solid rgba(139, 125, 161, 0.3);
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .badge-rejete {
            background: linear-gradient(135deg, rgba(183, 165, 190, 0.1), rgba(183, 165, 190, 0.2));
            color: #B7A5BE;
            border: 1px solid rgba(183, 165, 190, 0.3);
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Styles pour les boutons d'action */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            margin: 0 0.125rem;
            background: transparent;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            background-color: rgba(0,0,0,0.05);
        }
        
        .btn-view {
            color: #5E60CE;
        }
        
        .btn-view:hover {
            color: #4F50AD;
        }
        
        .btn-resolve {
            color: #8B7DA1;
        }
        
        .btn-resolve:hover {
            color: #7A6B91;
        }
        
        .btn-reject {
            color: #A8A29E;
        }
        
        .btn-reject:hover {
            color: #9C968E;
        }
        
        .btn-delete {
            color: #B7A5BE;
        }
        
        .btn-delete:hover {
            color: #A594AE;
        }
        
        /* Animation pour l'alerte de succès */
        .alert-success-custom {
            background: linear-gradient(135deg, rgba(139, 125, 161, 0.1), rgba(139, 125, 161, 0.05));
            border: 1px solid rgba(139, 125, 161, 0.3);
            color: #8B7DA1;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .alert-success-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #8B7DA1, #7A6B91);
        }
    </style>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Gestion des Signalements</h1>

        @if (session('success'))
            <div class="alert-success-custom">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl mr-3"></i>
                    <div>
                        <strong>Succès!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="ml-auto hover:text-violet-700" style="color: #8B7DA1;" onclick="this.parentElement.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Tableau des signalements -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-6 text-gray-800 flex items-center">
                <i class="fas fa-flag text-violet-custom mr-2"></i>
                Liste des Signalements
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead class="bg-violet-50">
                        <tr>
                            <th class="py-4 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Type de Contenu</th>
                            <th class="py-4 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Raison du Signalement</th>
                            <th class="py-4 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Date de Signalement</th>
                            <th class="py-4 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">État</th>
                            <th class="py-4 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="hover:bg-violet-50 transition-colors duration-150">
                                <td class="py-4 px-4 border-b border-gray-200">
                                    <div class="font-medium text-gray-800">
                                        {{ ucfirst($report->content_type) }}
                                    </div>
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200">
                                    <div class="text-gray-700 max-w-xs truncate" title="{{ $report->reason }}">
                                        {{ $report->reason }}
                                    </div>
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200">
                                    <div class="text-gray-600">
                                        {{ $report->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200">
                                    @if ($report->status == 'nouveau')
                                        <span class="badge-nouveau">
                                            <i class="fas fa-bell"></i> Nouveau
                                        </span>
                                    @elseif ($report->status == 'en_cours')
                                        <span class="badge-en-cours">
                                            <i class="fas fa-hourglass-half"></i> En cours
                                        </span>
                                    @elseif ($report->status == 'resolu')
                                        <span class="badge-resolu">
                                            <i class="fas fa-check-circle"></i> Résolu
                                        </span>
                                    @elseif ($report->status == 'rejete')
                                        <span class="badge-rejete">
                                            <i class="fas fa-ban"></i> Rejeté
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200">
                                    <div class="flex justify-center items-center space-x-1">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('admin.reports.show', $report->id) }}" class="action-btn btn-view" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Bouton Résoudre -->
                                        <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="action-btn btn-resolve" title="Marquer comme résolu">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>

                                        <!-- Bouton Rejeter -->
                                        <form action="{{ route('admin.reports.reject', $report->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="action-btn btn-reject" title="Rejeter le signalement">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>

                                        <!-- Bouton Supprimer -->
                                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" title="Supprimer le signalement" onclick="return confirm('Confirmer la suppression ?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($reports->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500 mb-2">Aucun signalement trouvé</p>
                        <p class="text-gray-400">Il n'y a actuellement aucun signalement à traiter.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection