<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord étudiant')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: rgb(242, 244, 247);
            color: #333;
            margin: 0;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode {
            background-color: #1a1a1a;
            color: #f0f2f5;
        }

        .navbar {
            background-color: #004b6d;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            font-weight: 600;
        }

        .navbar a:hover {
            color: rgb(145, 157, 168);
        }

        .navbar .mode-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        /* Cercle pour initiale de l'étudiant */
        .navbar .user-circle {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(14, 122, 130);  /* Couleur personnalisée */
            color: white;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        /* Dropdowns */
        .dropdown-menu {
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu .dropdown-item {
            color: #004b6d;
            font-size: 14px; /* Taille de police réduite pour les éléments du menu */
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #007bff;
            color: white;
        }

        .dropdown-menu .dropdown-item.selected {
            background-color: #004b6d;
            color: white;
        }

        .content {
            padding: 20px;
        }

        /* Ajout d'une marge entre le Dark Mode et le cercle */
        .navbar .mode-toggle {
            margin-right: 12px; /* Marge entre le Dark Mode et le cercle */
        }

        /* Ajout de l'alignement pour les éléments de la navbar */
        .navbar .d-flex.align-items-center {
            display: flex;
            align-items: center;
            gap: 10px; /* Espacement entre les éléments */
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <!-- Colonne de gauche avec les liens -->
        <div>
            <a href="{{ route('etudiant.home') }}"><i class="fas fa-home"></i> home</a>
            <a href="{{ route('forumetudiants.index') }}"><i class="fas fa-comments"></i> Forum</a>
            <a href="{{ route('notifications.index') }}" class="position-relative">
                <i class="fas fa-bell fa-1x"></i> <!-- L'icône de notification avec une taille agrandie -->
                @php
                    $notif_count = App\Models\Notification::where('id_user', auth()->id())->where('lue', false)->count();
                @endphp
                @if($notif_count > 0)
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                        {{ $notif_count }}
                    </span>
                @endif
            </a>
        </div>

        <!-- Sélecteurs d'année, filière, matière et type de support -->
        <div>
            <form method="GET" action="{{ route('etudiant.dashboard') }}" style="display: inline-block;">
                <select name="annee" class="form-select" onchange="this.form.submit()" style="display: inline-block; width: auto;">
                    <option value="">Choisissez l'année</option>
                    <option value="1" {{ request('annee') == '1' ? 'selected' : '' }}>1ère année</option>
                    <option value="2" {{ request('annee') == '2' ? 'selected' : '' }}>2ème année</option>
                </select>
            </form>

            <!-- Dropdown Filière -->
            @if(request('annee'))
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="filiereDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Filière
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filiereDropdown">
                        @foreach($filieres as $filiere)
                            <li>
                                <a class="dropdown-item {{ request('filiere_id') == $filiere->id_filiere ? 'selected' : '' }}" href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => $filiere->id_filiere]) }}">
                                    {{ $filiere->nom_filiere }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Dropdown Matière -->
            @if(request('filiere_id'))
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="matiereDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Matière
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="matiereDropdown">
                        @foreach($matières as $matiere)
                            <li>
                                <a class="dropdown-item {{ request('matiere_id') == $matiere->id_Matiere ? 'selected' : '' }}" href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => request('filiere_id'), 'matiere_id' => $matiere->id_Matiere]) }}">
                                    {{ $matiere->Nom }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Dropdown Type -->
            @if(request('matiere_id'))
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="typeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Type de support
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="typeDropdown">
                        @foreach($types as $type)
                            <li>
                                <a class="dropdown-item {{ request('type_id') == $type->id_type ? 'selected' : '' }}" href="{{ route('etudiant.dashboard', ['annee' => request('annee'), 'filiere_id' => request('filiere_id'), 'matiere_id' => request('matiere_id'), 'type_id' => $type->id_type]) }}">
                                    {{ $type->nom }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Colonne de droite avec le cercle de l'étudiant et le bouton Dark Mode -->
<div class="d-flex align-items-center">
    <!-- Cercle avec initiale de l'étudiant -->
    <div class="dropdown d-inline position-relative">
        <!-- Bouton: Positionner normalement à l'intérieur du cercle -->
        <button class="user-circle dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ strtoupper(auth()->user()->prenom[0]) }} <!-- Affiche la première lettre du prénom -->
        </button>
        
        <!-- Menu déroulant: Positionné à l'intérieur du bouton et à gauche -->
        <ul class="dropdown-menu position-absolute start-0" aria-labelledby="userDropdown" style="top:100%; left:0;">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Gestion du profil</a></li>
            <li>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Déconnexion
                </a>
            </li>
        </ul>
    </div>
</div>


            <!-- Bouton Dark Mode -->
            <button class="mode-toggle" onclick="toggleDarkMode()">🌙</button>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="content">
        @yield('content')
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>

</body>
</html>