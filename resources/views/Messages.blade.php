<!DOCTYPE html>  <html lang="fr">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Messages</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
</head>  
<body>  
    <div class="container mt-4">  
        <h2 class="mb-4">Messages (Questions & Réponses)</h2>    
        <!-- Affichage des messages de succès -->  
        @if(session('success'))  
            <div class="alert alert-success">  
                {{ session('success') }}  
            </div>  
        @endif  <!-- Formulaire pour poser une question -->  
    <div class="card mb-4">  
        <div class="card-header">Poser une nouvelle question</div>  
        <div class="card-body">  
            <form action="{{ route('questions.store') }}" method="POST">  
                @csrf  
                <div class="mb-3">  
                    <label for="titre" class="form-label">Titre de la question :</label>  
                    <input type="text" class="form-control" id="titre" name="titre" required>  
                </div>  
                <div class="mb-3">  
                    <label for="contenue" class="form-label">Contenue :</label>  
                    <textarea class="form-control" id="contenue" name="contenue" rows="4" required></textarea>  
                </div>  
                <button type="submit" class="btn btn-primary">Envoyer</button>  
            </form>  
        </div>  
    </div>  

    <!-- Liste des questions et réponses -->  
    <div class="card">  
        <div class="card-header">Vos Questions et Réponses</div>  
        <div class="card-body">  
            @if($questions->isEmpty())  
                <p class="text-muted">Aucune question posée pour le moment.</p>  
            @else  
                @foreach($questions as $question)  
                    <div class="mb-4">  
                        <h5>{{ $question->titre }}</h5>  
                        <p>{{ $question->contenue }}</p>  
                        <p class="text-muted">Posté le {{ $question->created_at->format('d/m/Y à H:i') }}</p>  

                        <!-- Boutons de modification et suppression -->  
                        <div class="d-flex justify-content-between">  
                            <!-- Formulaire de suppression -->  
                            <form action="{{ route('questions.destroy', $question->id_question) }}" method="POST" style="display:inline;">  
                                @csrf  
                                @method('DELETE')  
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>  
                            </form>  

                            <!-- Bouton de modification -->  
                            <a href="{{ route('questions.edit', $question->id_question) }}" class="btn btn-warning btn-sm">Modifier</a>  
                        </div>  

                        <!-- Affichage des réponses -->  
                        <div class="ms-4">  
                            @foreach($reponses->where('id_question', $question->id_question) as $reponse)  
                                <div class="alert alert-secondary">  
                                    <p>{{ $reponse->contenu }}</p>  
                                    <p class="text-muted">Répondu le {{ $reponse->created_at->format('d/m/Y à H:i') }}</p>  
                                </div>  
                            @endforeach  
                        </div>  
                    </div>  
                    <hr>  
                @endforeach  
            @endif  
        </div>  
    </div>  
</div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>  
</html>