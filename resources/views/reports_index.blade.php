@extends('layouts.admin')

@section('title', 'Gestion des Signalements')  

@section('content')
    <div class="container">
        <h1 class="mb-4">Liste des Signalements</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Succès!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Type de Contenu</th>
                    <th>Raison du Signalement</th>
                    <th>Date de Signalement</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ ucfirst($report->content_type) }}</td>
                        <td>{{ $report->reason }}</td>
                        <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <!-- Affichage des icônes et couleurs pour les statuts -->
                            @if ($report->status == 'nouveau')
                                <span class="badge badge-info">
                                    <i class="fas fa-bell"></i> Nouveau
                                </span>
                            @elseif ($report->status == 'en_cours')
                                <span class="badge badge-warning">
                                    <i class="fas fa-hourglass-half"></i> En cours
                                </span>
                            @elseif ($report->status == 'resolu')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Résolu
                                </span>
                            @elseif ($report->status == 'rejete')
                                <span class="badge badge-danger">
                                    <i class="fas fa-ban"></i> Rejeté
                                </span>
                            @endif
                        </td>
                        <td>
                            <!-- Voir le contenu signalé -->
                            <a href="{{ route('reports.viewContent', $report->id) }}" class="btn btn-outline-primary btn-sm" title="Voir le contenu">
                                <i class="fas fa-eye"></i> Voir
                            </a>

                            <!-- Marquer comme résolu -->
                            <form action="{{ route('reports.resolve', $report->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-outline-success btn-sm" title="Marquer comme résolu">
                                    <i class="fas fa-check-circle"></i> Résoudre
                                </button>
                            </form>

                            <!-- Supprimer le contenu -->
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" title="Supprimer le signalement">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </button>
                            </form>

                            <!-- Rejeter le signalement -->
                            <form action="{{ route('reports.reject', $report->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-outline-warning btn-sm" title="Rejeter le signalement">
                                    <i class="fas fa-ban"></i> Rejeter
                                </button>
                            </form>

                            <!-- Contacter l'auteur -->
                            <a href="{{ route('reports.contactAuthor', $report->id) }}" class="btn btn-outline-info btn-sm" title="Contacter l'auteur">
                                <i class="fas fa-envelope"></i> Contacter
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
