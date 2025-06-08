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

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    @section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'violet-custom': '#5E60CE',
                        'violet-light': '#7879E3',
                        'violet-dark': '#4F50AD',
                    }
                }
            }
        }
    </script>

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
        .bg-violet-100 {
            background-color: rgba(94, 96, 206, 0.1);
        }
        .hover\:bg-violet-700:hover {
            background-color: #4F50AD;
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

        /* Navbar moderne avec glassmorphism */
        .navbar-glass {
            background: rgba(94, 96, 206, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Animation pour les liens de navigation */
        .nav-link-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .nav-link-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .nav-link-modern:hover::before {
            left: 100%;
        }

        /* Badge notification animé - Amélioré */
        .notification-badge {
            animation: pulse 2s infinite;
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 20px;
            height: 20px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        /* Avatar avec effet de brillance */
        .avatar-shine {
            position: relative;
            overflow: hidden;
        }

        .avatar-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.6s;
            opacity: 0;
        }

        .avatar-shine:hover::after {
            opacity: 1;
            transform: rotate(45deg) translate(50%, 50%);
        }

        /* Dropdown moderne */
        .dropdown-modern {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(94, 96, 206, 0.1);
            overflow: hidden;
        }

        .dropdown-item-modern {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .dropdown-item-modern:hover {
            background-color: rgba(94, 96, 206, 0.05);
            border-left-color: #5E60CE;
            transform: translateX(5px);
        }

        /* Mobile menu amélioré */
        .mobile-menu {
            background: rgba(94, 96, 206, 0.98);
            backdrop-filter: blur(15px);
        }

        /* CORRECTIONS POUR LA RESPONSIVITÉ MOBILE */
        
        /* S'assurer que le menu mobile reste ouvert après clic */
        .mobile-menu-open {
            display: block !important;
        }
        
        /* Améliorer l'affichage sur petits écrans */
        @media (max-width: 768px) {
            .navbar-glass {
                padding: 0.5rem 0;
            }
            
            .mobile-menu {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1000;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
            
            /* Améliorer l'espacement des liens mobiles */
            .mobile-menu a {
                padding: 1rem 1.5rem !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .mobile-menu a:last-child {
                border-bottom: none;
            }
        }
        
        /* Améliorer la visibilité du bouton hamburger */
        .mobile-menu-toggle {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .mobile-menu-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>

    {{-- Permet à chaque vue d'ajouter son propre contenu dans le <head> --}}
    @yield('head')
</head>
<body class="bg-gray-50 min-h-screen">

@php
    // Récupération du nombre de notifications non lues directement dans le layout
    $unreadCount = 0;
    if (auth()->check()) {
        try {
            // Supposons que vous avez une table notifications avec une colonne 'read_at'
            // Adaptez cette requête selon votre structure de base de données
            $unreadCount = \DB::table('notifications')
                ->where('notifiable_id', auth()->id())
                ->where('notifiable_type', get_class(auth()->user()))
                ->whereNull('read_at')
                ->count();
        } catch (\Exception $e) {
            // En cas d'erreur, on garde 0
            $unreadCount = 0;
        }
    }
@endphp

<!-- Navbar moderne -->
<nav class="navbar-glass shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('professeur.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-gray-200 transition-colors duration-200">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <span class="text-xl font-bold hidden sm:block">Espace Professeur</span>
                </a>
            </div>

            <!-- Navigation Links - Desktop -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('supports.index') }}" class="nav-link-modern flex items-center space-x-2 px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all duration-200">
                    <i class="fas fa-book text-sm"></i>
                    <span>Supports éducatifs</span>
                </a>
                
                
                <a href="{{ route('professeur.questions.index') }}" class="nav-link-modern flex items-center space-x-2 px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all duration-200">
                    <i class="fas fa-comments text-sm"></i>
                    <span>Forum</span>
                </a>


                <a href="{{ route('consultations.index') }}" class="nav-link-modern flex items-center space-x-2 px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all duration-200">
        <i class="fas fa-chart-bar text-sm"></i>
       <span>Consultations</span>
        </a>

                
                <!-- Notifications -->
                <a href="{{ route('professeur.notifications') }}" class="nav-link-modern relative flex items-center space-x-2 px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all duration-200">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="hidden lg:block">Notifications</span>
                    @isset($unreadNotificationsCount)
                        @if($unreadNotificationsCount > 0)
                            <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    @endisset
                </a>
            </div>

            <!-- Profile Dropdown -->
            <div class="flex items-center space-x-4">
                <!-- Desktop Profile -->
                <div class="hidden md:block relative">
                    <div class="dropdown">
                        <button class="avatar-shine flex items-center space-x-3 text-white hover:text-gray-200 transition-colors duration-200 p-2 rounded-lg hover:bg-white hover:bg-opacity-10" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center font-bold text-lg">
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
                            <div class="hidden lg:block text-left">
                                <div class="text-sm font-medium">{{ auth()->user()->prenom ?? 'Utilisateur' }}</div>
                                <div class="text-xs opacity-75">Professeur</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-modern dropdown-menu-end mt-2 w-48">
                            <li>
                                <a class="dropdown-item-modern flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-violet-custom" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit text-violet-custom"></i>
                                    <span>Modifier mon profil</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item-modern flex items-center space-x-3 px-4 py-3 text-red-600 hover:text-red-700" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden mobile-menu-toggle text-white hover:text-gray-200 transition-colors duration-200" type="button" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu md:hidden" id="mobileMenu" style="display: none;">
            <div class="py-4 space-y-1">
                <a href="{{ route('supports.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200 mx-4">
                    <i class="fas fa-book"></i>
                    <span>Supports éducatifs</span>
                </a>
                
                
                <a href="{{ route('professeur.questions.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200 mx-4">
                    <i class="fas fa-comments"></i>
                    <span>Forum</span>
                </a>

                <a href="{{ route('consultations.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200 mx-4">
                    <i class="fas fa-chart-bar"></i>
                    <span>Consultations</span>
                </a>
                
                <a href="{{ route('professeur.notifications') }}" class="flex items-center justify-between px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200 mx-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </div>
                    @isset($unreadNotificationsCount)
                        @if($unreadNotificationsCount > 0)
                            <span class="notification-badge bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    @endisset
                </a>

                <hr class="border-white border-opacity-20 my-4 mx-4">
                
                <!-- Mobile Profile Section -->
                <div class="px-4 py-3">
                    <div class="flex items-center space-x-3 mb-3 px-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center font-bold text-lg text-white">
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
                        <div class="text-white">
                            <div class="font-medium">{{ auth()->user()->prenom ?? 'Utilisateur' }} {{ auth()->user()->nom ?? '' }}</div>
                            <div class="text-sm opacity-75">Professeur</div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-3 py-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200">
                            <i class="fas fa-user-edit"></i>
                            <span>Modifier mon profil</span>
                        </a>
                        
                        <a href="{{ route('logout') }}" class="flex items-center space-x-3 px-3 py-2 text-red-300 hover:text-red-200 hover:bg-red-500 hover:bg-opacity-20 rounded-lg transition-all duration-200"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Formulaire de déconnexion caché -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<!-- Contenu principal avec padding et design moderne -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb optionnel -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('professeur.dashboard') }}" class="hover:text-violet-custom transition-colors duration-200">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-violet-custom font-medium">@yield('breadcrumb', 'Tableau de bord')</span>
        </nav>
    </div>

    <!-- Zone de contenu avec fond blanc et ombres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @yield('content')
    </div>
</main>

<!-- Scripts Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour améliorer l'UX -->
<script>
    // NOUVEAU: Fonction pour gérer le menu mobile sans fermeture automatique
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
            mobileMenu.style.display = 'block';
            mobileMenu.classList.add('mobile-menu-open');
        } else {
            mobileMenu.style.display = 'none';
            mobileMenu.classList.remove('mobile-menu-open');
        }
    }

    // Fermer le menu mobile si on clique en dehors
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobileMenu');
        const toggleButton = document.querySelector('.mobile-menu-toggle');
        
        if (!mobileMenu.contains(event.target) && !toggleButton.contains(event.target)) {
            if (mobileMenu.style.display === 'block') {
                mobileMenu.style.display = 'none';
                mobileMenu.classList.remove('mobile-menu-open');
            }
        }
    });

    // SUPPRIMÉ: L'ancien code qui fermait automatiquement le menu après clic sur un lien
    // Ce code causait le problème de fermeture immédiate

    // Animation de chargement
    window.addEventListener('load', () => {
        document.body.classList.add('loaded');
    });

    // Mise à jour automatique du compteur de notifications (optionnel)
    setInterval(function() {
        // Vous pouvez ajouter ici une requête AJAX pour mettre à jour le compteur
        // sans recharger la page
    }, 60000); // Toutes les minutes
</script>
@yield('scripts')

</body>
</html>


