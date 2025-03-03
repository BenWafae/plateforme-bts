<!DOCTYPE html>      
<html lang="fr">      
<head>      
    <meta charset="UTF-8">      
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <title>Tableau de bord étudiant</title>      
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">      
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">      
    <style>      
        body {      
            font-family: 'Arial', sans-serif;      
            background-color: #f4f6f9;      
            color: #34495e;      
        }      
    
        /* Sidebar */
.sidebar {
    background-color: rgb(25, 49, 77); /* Couleur de fond */
    color: #ecf0f1; /* Couleur du texte */
    height: 100vh; /* Hauteur pleine page */
    position: fixed; /* Fixe la sidebar à l'écran */
    top: 0; /* Toujours en haut de la page */
    left: 0; /* Toujours à gauche de la page */
    width: 260px; /* Largeur de la sidebar */
    padding-top: 20px; /* Espace au-dessus du contenu */
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1); /* Ombre portée sur la sidebar */
    z-index: 1000; /* Assure que la sidebar est au-dessus d'autres éléments */
}

/* Pour éviter que le contenu principal ne soit caché sous la sidebar */
.content {
    margin-left: 260px; /* Espace laissé pour la sidebar */
    padding: 20px;
}      
        }      
        .sidebar .nav-link {      
            color: #bdc3c7;      
            padding: 12px 20px;      
            font-size: 16px;      
            text-align: left;      
        }      
        .sidebar .nav-link.active {      
            background-color:rgb(39, 58, 71);      
            color: white;      
        }      
        .sidebar .nav-link:hover {      
            background-color:rgb(30, 64, 86);      
            color: white;      
        }      
        .sidebar .nav-link i {      
            margin-right: 10px;      
        }      
        .sidebar .nav-item {      
            border-bottom: 1px solid #34495e;      
        }      
    
        /* Contenu principal */      
        .content {      
            margin-left: 270px;      
            padding: 20px;      
        }      
        .content-header {      
            margin-bottom: 20px;      
        }      
    
        /* Barre de type sélectionné */      
        .selected-type-bar {      
            background-color:rgb(9, 51, 78);      
            color: white;      
            padding: 10px 20px;      
            margin-bottom: 20px;      
            font-size: 18px;      
            font-weight: bold;      
            border-radius: 5px;      
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);      
        }      
    
        /* Améliorer les cartes */      
        .card {      
            background-color: #ffffff;      
            border: 1px solid #ecf0f1;      
            border-radius: 10px;      
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);      
            margin-bottom: 20px;      
        }      
        .card-header {      
            background-color:rgb(104, 160, 195);      
            color: white;      
            font-weight: bold;      
            border-top-left-radius: 10px;      
            border-top-right-radius: 10px;      
        }      
        .card-body {      
            padding: 15px;      
        }      
        .card .download-btn {      
            background-color:rgb(20, 66, 99);      
            color: white;      
            padding: 8px 15px;      
            border-radius: 5px;      
            text-decoration: none;      
            transition: background-color 0.3s ease;      
        }      
        .card .download-btn:hover {      
            background-color:rgb(12, 47, 77);      
        }      
    
        /* Uniformiser la longueur des cartes */      
        .card-deck {      
            display: flex;      
            flex-wrap: wrap;      
            gap: 20px;      
        }      
        .card {      
            flex: 1 0 30%;      
            min-width: 300px;      
            max-width: 350px;      
        }      
    
        /* Section mobile */      
        @media (max-width: 768px) {      
            .card-deck {      
                display: block;      
            }      
            .sidebar {      
                width: 100%;      
                position: relative;      
                height: auto;      
            }      
            .content {      
                margin-left: 0;      
            }      
        }      
    
        /* Sélection type support affiché */      
        .type-bar {      
            background-color:rgb(13, 65, 100);      
            color: white;      
            padding: 15p;      
            margin-bottom: 10px;      
            font-size: 10px;      
            font-weight: bold;      
            border-radius: 5px;      
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);      
        }    
    
        /* Section bienvenue */    
        .welcome-message {    
            background-color:rgb(3, 38, 62);    
            color: white;    
            padding: 15px;    
            border-radius: 5px;    
            margin-bottom: 30px;    
            font-size: 20px;    
            font-weight: bold;    
        }    
    
        /* Barre de navigation du haut */    
        .top-bar {    
            background-color:rgb(2, 36, 56);    
            color: white;    
            padding: 10px 20px;    
            display: flex;    
            justify-content: space-between;    
            align-items: center;    
        }    
    
        .top-bar .notifications {    
            display: flex;    
            justify-content: flex-end;    
        }    
    </style>      
</head>      
<body>      
    <!-- Sidebar -->      
    <div class="sidebar">      
        <ul class="nav flex-column">      
            <li class="nav-item">      
                <a class="nav-link active" href="{{ route('etudiant.dashboard') }}">      
                    <i class="fas fa-home"></i> Accueil      
                </a>      
            </li>
    
            <!-- Sélection de l'année -->      
            <li class="nav-item">      
                <form method="GET" action="{{ route('etudiant.dashboard') }}">      
                    <label for="annee" class="form-label text-white"><i class="fas fa-calendar-alt"></i> Choisissez l'année :</label>      
                    <select id="annee" name="annee" class="form-select" onchange="this.form.submit()">      
                        <option value="">Sélectionner une année</option>      
                        <option value="1 ere annee" {{ request('annee') == '1 ere annee' ? 'selected' : '' }}>1ère année</option>      
                        <option value="2 eme annee" {{ request('annee') == '2 eme annee' ? 'selected' : '' }}>2ème année</option>      
                    </select>      
                </form>      
            </li>      
    
            <!-- Filières et matières -->      
            @if(request('annee'))      
                <li class="nav-item mt-3">      
                    <h5 class="text-white"><i class="fas fa-graduation-cap"></i> Filières</h5>      
                    <ul class="nav flex-column ms-3">      
                        @foreach($filieres as $filiere)      
                            <li class="nav-item">      
                                <a class="nav-link" href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => $filiere->id_filiere]) }}">      
                                    <i class="fas fa-book-open"></i> {{ $filiere->nom_filiere }}      
                                </a>      
                            </li>      
    
                            @if(request('filiere_id') == $filiere->id_filiere)      
                                <ul class="nav flex-column ms-4">      
                                    @foreach($matières as $matiere)      
                                        <li class="nav-item">      
                                            <a class="nav-link" href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => $filiere->id_filiere, 'matiere_id' => $matiere->id_Matiere]) }}">      
                                                <i class="fas fa-book"></i> {{ $matiere->Nom }}      
                                            </a>      
                                        </li>      
    
                                        <!-- Types de supports -->      
                                        @if(request('matiere_id') == $matiere->id_Matiere)      
                                            <ul class="nav flex-column ms-4">      
                                                @foreach($types as $type)      
                                                    <li class="nav-item">      
                                                        <a class="nav-link" href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => request('filiere_id'), 'matiere_id' => request('matiere_id'), 'type_id' => $type->id_type]) }}">      
                                                            <i class="fas fa-file-alt"></i> {{ $type->nom }}      
                                                        </a>      
                                                    </li>      
                                                @endforeach      
                                            </ul>      
                                        @endif      
                                    @endforeach      
                                </ul>      
                            @endif      
                        @endforeach      
                    </ul>      
                </li>      
            @endif      
    
            <li class="nav-item">      
    <a class="nav-link" href="{{ route('messages.index') }}">      
        <i class="fas fa-envelope"></i> Messages      
    </a>      
</li>
            <li class="nav-item">      
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">      
                    <i class="fas fa-sign-out-alt"></i> Déconnexion      
                </a>      
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">      
                    @csrf      
                </form>      
            </li>      
        </ul>      
    </div>      
    
    <!-- Contenu principal -->      
    <div class="content">      
        <!-- Barre du haut avec notification et message de bienvenue -->    
        <div class="top-bar">    
            <!-- Message de bienvenue -->    
            <div class="welcome-message">    
                Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}!    
            </div>    
    
            <!-- Bouton de notification avec une icône -->    
            <div class="notifications">    
                <button class="btn btn-outline-light" id="notificationButton">    
                    <i class="fa fa-bell"></i> Notifications    
                </button>    
            </div>    
        </div>    
    
        <!-- Affichage du type sélectionné -->      
        @if(request('type_id'))    
            <div class="selected-type-bar">    
                <i class="fas fa-file-alt"></i>     
                @foreach($types as $type)    
                    @if($type->id_type == request('type_id'))    
                        {{ $type->nom }}    
                    @endif    
                @endforeach    
            </div>    
        @endif    
      
        <div class="content-header">      
            <h2>Supports éducatifs</h2>      
            <p>Consultez vos supports en cliquant sur les matières et les types de supports.</p>      
        </div>      
    
        <!-- Affichage des supports éducatifs -->
        @if(request('type_id'))
            <h4>Supports du type</h4>
            <div class="card-deck">
                @foreach($supports as $support)
                    @if($support->id_type == request('type_id'))
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-file-alt"></i> {{ $support->titre }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $support->description }}</p>
                                <!-- Bouton de téléchargement ou ouverture -->
                                @if(strpos($support->format, 'pdf') !== false)
                                <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" class="download-btn" target="_blank">
                                    <i class="fas fa-eye"></i> Ouvrir
                                </a>
                                @else
                                <a href="{{ route('etudiant.supports.download', ['id' => $support->id_support]) }}" class="download-btn">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p>Aucun support disponible pour ce type.</p>
        @endif
    </div>
    

    <!-- Scripts de Bootstrap et FontAwesome -->      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>      
</body>      
</html>