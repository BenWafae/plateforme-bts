<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord étudiant')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Couleurs professionnelles et épurées */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5; /* Gris clair */
            color: #333;
        }

        .sidebar {
            background-color: #ffffff; /* Blanc */
            color: #333;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding-top: 30px;
            overflow-y: auto; /* Permettre le scroll */
            max-height: 100vh; /* Empêcher le dépassement */
        }

        /* Personnalisation de la scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgb(5, 47, 75);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .sidebar .nav-link {
            color: #666;
            padding: 12px 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color:rgb(5, 47, 75); /* Bleu */
            color: #fff;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            margin-left: 270px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            background-color:rgb(4, 48, 78);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" href="{{ route('etudiant.dashboard') }}">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>

            <!-- Sélection de l'année -->
            <li class="nav-item">
                <form method="GET" action="{{ route('etudiant.dashboard') }}">
                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Choisissez l'année :</label>
                    <select name="annee" class="form-select" onchange="this.form.submit()">
                        <option value="">Sélectionner une année</option>
                        <option value="1 ere annee" {{ request('annee') == '1 ere annee' ? 'selected' : '' }}>1ère année</option>
                        <option value="2 eme annee" {{ request('annee') == '2 eme annee' ? 'selected' : '' }}>2ème année</option>
                    </select>
                </form>
            </li>

            <!-- Affichage des filières, matières et types de supports -->
            @if(request('annee'))
                <li class="nav-item mt-3">
                    <h5 class="text-dark"><i class="fas fa-graduation-cap"></i> Filières</h5>
                    <ul class="nav flex-column ms-3">
                        @foreach($filieres as $filiere)
                            <li class="nav-item">
                                <a class="nav-link {{ request('filiere_id') == $filiere->id_filiere ? 'active' : '' }}" 
                                   href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => $filiere->id_filiere]) }}">
                                    <i class="fas fa-book-open"></i> {{ $filiere->nom_filiere }}
                                </a>
                            </li>

                            @if(request('filiere_id') == $filiere->id_filiere && isset($matières))
                                <ul class="nav flex-column ms-4">
                                    @foreach($matières as $matiere)
                                        <li class="nav-item">
                                            <a class="nav-link {{ request('matiere_id') == $matiere->id_Matiere ? 'active' : '' }}" 
                                               href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => $filiere->id_filiere, 'matiere_id' => $matiere->id_Matiere]) }}">
                                                <i class="fas fa-book"></i> {{ $matiere->Nom }}
                                            </a>
                                        </li>

                                        @if(request('matiere_id') == $matiere->id_Matiere && isset($types))
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

            <!-- Bouton Messages -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('messages.index') }}">
                    <i class="fas fa-envelope"></i> question et réponse
                </a>
            </li>

            <!-- Déconnexion -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        <div class="top-bar">
            <div class="welcome-message">Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}!</div>
        </div>

        @yield('content')  <!-- Le contenu spécifique à chaque page sera affiché ici -->
    </div>

</body>
</html>
