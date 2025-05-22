<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Professeur')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Lien Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Lien FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Ajout du style personnalisé */
        .navbar-nav .nav-link:hover {
            background-color: #1abc9c;  /* Couleur verte au survol des liens */
            color: white;
        }

        .navbar-nav .nav-link {
            color: white;
        }

        /* Pour l'avatar */
        .navbar-nav .nav-item .nav-link .rounded-circle {
            background-color: #1abc9c;  /* Fond vert pour le cercle */
            color: white;
            font-weight: bold;
        }

        .navbar-nav .nav-item .nav-link .rounded-circle:hover {
            background-color: #16a085; /* Couleur légèrement plus foncée au survol */
        }

        /* Responsive pour les petits écrans */
        @media (max-width: 768px) {
            .navbar-nav .nav-link {
                font-size: 14px; /* Réduire la taille des liens dans la navbar */
            }
        }
    </style>
     {{-- Permet à chaque vue d'ajouter son propre contenu dans le <head> --}}
    @yield('head')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('professeur.dashboard') }}">Espace Professeur</a>

        <!-- Bouton hamburger (pour mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens à gauche -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('supports.index') }}"><i class="fas fa-book"></i> Supports éducatifs</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('supports.create') }}"><i class="fas fa-plus"></i> Ajouter un Support</a>
                </li>
                {{-- forum --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('professeur.questions.index') }}"><i class="fas fa-comments"></i> Forum</a>
                </li>

                {{-- notification --}}
<li class="nav-item">
    <a class="nav-link" href="{{ route('professeur.notifications') }}">
        <i class="fas fa-bell"></i>
        @isset($unreadNotificationsCount)
            @if($unreadNotificationsCount > 0)
                <span class="badge bg-danger">{{ $unreadNotificationsCount }}</span>
            @endif
        @endisset
    </a>
</li>




            </ul>
      


            <!-- Avatar + Dropdown Profil (tout à droite) -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; font-size: 18px;">
                            <!-- Affichage des initiales de l'utilisateur connecté -->
                            @if(auth()->check())
                                @php
                                    $prenom = auth()->user()->prenom;
                                    $nom = auth()->user()->nom;
                                    $initials = strtoupper(substr($prenom, 0, 1)) . strtoupper(substr($nom, 0, 1));
                                @endphp
                                {{ $initials }}
                            @else
                                <span>N/A</span>
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Modifier mon profil</a></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Formulaire de déconnexion caché -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<div class="container mt-4">
    @yield('content')
</div>

<!-- Scripts Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
{{-- script vite pour echo --}}
@vite('resources/js/app.js')


</body>
</html>


