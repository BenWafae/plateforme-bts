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

        /* Style du cercle utilisateur */
        .user-circle {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(14, 122, 130);
            color: white;
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        /* Style des boutons de notification et forum */
         /* Boutons Notification et Forum agrandis */
         .notif-btn, .forum-btn {
            font-size: 50px;
            position: relative;
            padding: 10px 10px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        .notif-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 12px;
            background-color: red;
            color: white;
            padding: 5px 8px;
            border-radius: 50%;
        }

        /* Style des dropdowns */
        .dropdown-menu {
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu .dropdown-item {
            color: #004b6d;
            font-size: 14px;
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

        /* Aligner les éléments de droite */
        .navbar .right-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <!-- Liens de gauche -->
        <div>
            <a href="{{ route('etudiant.home') }}"><i class="fas fa-home"></i> Home</a>
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

            @if(request('annee'))
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="filiereDropdown">
                        Filière
                    </button>
                    <ul class="dropdown-menu">
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

            @if(request('filiere_id'))
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="matiereDropdown">
                        Matière
                    </button>
                    <ul class="dropdown-menu">
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

            @if(request('matiere_id'))
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="typeDropdown">
                        Type de support
                    </button>
                    <ul class="dropdown-menu">
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

        <!-- Section de droite -->
        <div class="right-section">
            <!-- Bouton Forum -->
            <a href="{{ route('forumetudiants.index') }}" class="forum-btn">
                <i class="fas fa-comments"></i>
            </a>

            <!-- Bouton Notification -->
            <a href="{{ route('notifications.index') }}" class="notif-btn position-relative">
                <i class="fas fa-bell"></i>
                @php
                    $notif_count = App\Models\Notification::where('id_user', auth()->id())->where('lue', false)->count();
                @endphp
                @if($notif_count > 0)
                    <span class="badge bg-danger">{{ $notif_count }}</span>
                @endif
            </a>

            <!-- Cercle utilisateur -->
            <div class="dropdown">
                <button class="user-circle dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                    {{ strtoupper(auth()->user()->prenom[0]) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Gestion du profil</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>