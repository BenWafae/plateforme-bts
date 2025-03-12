<!-- resources/views/admin/questions/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Liste des Questions</h2>

    <!-- Affichage du message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">Titre</th>
                <th class="text-center">Posée par</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
            <tr>
                <td class="text-center">{{ $question->titre }}</td>
                <td class="text-center">{{ $question->user->nom }} {{ $question->user->prenom }}</td>
                <td class="text-center">
                    <!-- Alignement des boutons au centre avec un espacement entre eux -->
                    <div class="d-flex justify-content-center">
                        <!-- Détails Button avec une icône -->
                        <a href="{{ route('admin.questions.show', $question->id_question) }}" class="btn btn-info btn-sm mr-3" 
                           style="padding: 8px 15px; font-size: 14px; border-radius: 5px; border: none; 
                           box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s, transform 0.2s;">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Formulaire de suppression de la question -->
                        <form action="{{ route('admin.questions.destroy', $question->id_question) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    style="padding: 8px 15px; font-size: 14px; border-radius: 5px; border: none; 
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s, transform 0.2s;" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                <i class="fas fa-trash-alt"></i> 
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection





