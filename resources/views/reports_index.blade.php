@extends('layouts.admin')

@section('title', 'Gestion des Signalements')  

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des Signalements</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
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
                <th>État</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ ucfirst($report->content_type) }}</td>
                    <td>{{ $report->reason }}</td>
                    <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                    <td>
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
                    <td class="text-center">
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="text-primary mx-1" title="Voir les détails">
                            <i class="fas fa-eye fa-lg"></i>
                        </a>

                        <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-link p-0 text-success mx-1" title="Marquer comme résolu">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.reject', $report->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-link p-0 text-warning mx-1" title="Rejeter le signalement">
                                <i class="fas fa-ban fa-lg"></i>
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 text-danger mx-1" title="Supprimer le signalement" onclick="return confirm('Confirmer la suppression ?')">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
