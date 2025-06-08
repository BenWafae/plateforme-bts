<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Administrateur')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Chart.js CDN (à ajouter dans layouts.admin)  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            display: flex;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar principale */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: white;
            color: #333;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        /* En-tête de la sidebar */
        .sidebar-header {
            padding: 1.25rem;
            background: #5E60CE;
            color: white;
            text-align: center;
            font-weight: bold;
            font-size: 1.25rem;
        }

        /* Navigation */
        .sidebar-nav {
            flex-grow: 1;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            overflow-y: auto;
            min-height: 0;
            max-height: calc(100vh - 200px); /* Réserver l'espace pour header et footer */
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #4B5563;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background-color: rgba(94, 96, 206, 0.05);
            color: #5E60CE;
            border-left-color: #5E60CE;
        }

        .nav-link.active {
            background-color: rgba(94, 96, 206, 0.1);
            color: #5E60CE;
            border-left-color: #5E60CE;
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            margin-right: 10px;
            font-size: 1.1rem;
            text-align: center;
        }

        /* Badge de notification */
        .badge-notification {
            position: absolute;
            top: 10px;
            right: 15px;
            background-color: #EF4444;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            min-width: 18px;
            text-align: center;
        }

        /* Section profil avec déconnexion intégrée */
        .profile-section {
            padding: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #F9FAFB;
            flex-shrink: 0;
            margin-top: auto;
        }

        .logout-section {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            width: 100%;
            background: linear-gradient(135deg, #5E60CE, #4C4FCF);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #4C4FCF, #3730A3);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(94, 96, 206, 0.3);
        }

        .logout-btn i {
            font-size: 1rem;
        }

        .profile-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background-color: #5E60CE;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1rem;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            margin: 0;
            font-size: 0.9rem;
        }

        .profile-role {
            color: #6B7280;
            font-size: 0.8rem;
            margin: 0;
        }

        /* Contenu principal */
        .content {
            margin-left: 260px;
            padding: 1.5rem;
            width: calc(100% - 260px);
            transition: all 0.3s ease;
        }

        /* Bouton de réduction de la sidebar */
        .sidebar-collapse-btn {
            position: absolute;
            top: 1rem;
            right: -12px;
            width: 24px;
            height: 24px;
            background-color: #5E60CE;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            border: 2px solid white;
            transition: transform 0.3s ease;
        }

        .sidebar-collapse-btn i {
            font-size: 0.75rem;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1.25rem 0.5rem;
            font-size: 0;
        }

        .sidebar.collapsed .sidebar-header i {
            font-size: 1.5rem;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .profile-info {
            display: none;
        }

        .sidebar.collapsed ~ .content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        .sidebar.collapsed .nav-link {
            padding: 0.75rem;
            justify-content: center;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .sidebar.collapsed .profile-section {
            padding: 0.75rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar.collapsed .profile-content {
            justify-content: center;
        }

        .sidebar.collapsed .logout-section {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        .sidebar.collapsed .logout-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            padding: 0;
            min-width: auto;
        }

        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar.collapsed .sidebar-collapse-btn {
            transform: rotate(180deg);
        }

        /* Séparateur */
        .menu-separator {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.05);
            margin: 0.5rem 1rem;
        }

        /* Bouton toggle sidebar (visible uniquement en mobile) */
        .toggle-sidebar {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1002;
            background-color: #5E60CE;
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .toggle-sidebar:hover {
            background-color: #4C4FCF;
            transform: translateY(-1px);
        }

        /* Overlay pour mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Animation pour les transitions */
        .sidebar, .content {
            transition: all 0.3s ease;
        }

        /* Responsive Breakpoints */
        
        /* Tablettes (768px - 1199px) */
        @media (max-width: 1199px) and (min-width: 768px) {
            .sidebar {
                width: 220px;
            }
            
            .content {
                margin-left: 220px;
                width: calc(100% - 220px);
            }
            
            .sidebar.collapsed ~ .content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
        }

        /* Mobiles et petites tablettes (max-width: 767px) */
        @media (max-width: 767px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                z-index: 1000;
                height: 100vh;
                overflow-y: auto;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }
            
            .toggle-sidebar {
                display: block;
            }
            
            /* Masquer le bouton de collapse en mobile */
            .sidebar-collapse-btn {
                display: none;
            }
            
            /* Ajuster le header en mobile */
            .sidebar-header {
                padding: 1rem;
                font-size: 1.1rem;
                flex-shrink: 0;
            }
            
            /* Ajuster la navigation en mobile */
            .sidebar-nav {
                flex-grow: 1;
                overflow-y: auto;
                padding: 0.5rem 0;
                min-height: 0;
                max-height: calc(100vh - 180px); /* Plus d'espace pour la déconnexion */
            }
            
            .nav-link {
                padding: 0.875rem 1.5rem; /* Réduire légèrement le padding */
                font-size: 0.9rem;
            }
            
            .nav-link i {
                width: 20px;
                margin-right: 10px;
                font-size: 1.1rem;
            }
            
            /* S'assurer que la section profil est visible */
            .profile-section {
                flex-shrink: 0;
                margin-top: auto;
                padding: 0.875rem;
            }

            .logout-btn {
                padding: 0.675rem;
                font-size: 0.85rem;
            }
        }

        /* Très petits écrans (max-width: 480px) */
        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                height: 100vh;
                overflow-y: auto;
            }
            
            .content {
                padding: 0.75rem;
            }
            
            .toggle-sidebar {
                top: 0.75rem;
                left: 0.75rem;
                padding: 0.6rem;
            }
            
            .sidebar-header {
                font-size: 1rem;
                padding: 0.875rem;
                flex-shrink: 0;
            }
            
            .sidebar-nav {
                flex-grow: 1;
                overflow-y: auto;
                min-height: 0;
                max-height: calc(100vh - 160px);
            }
            
            .nav-link {
                padding: 0.75rem 1.25rem;
                font-size: 0.85rem;
            }
            
            .profile-section {
                padding: 0.75rem;
                flex-shrink: 0;
                margin-top: auto;
            }

            .logout-btn {
                padding: 0.6rem;
                font-size: 0.8rem;
            }
        }

        /* Mode paysage sur mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .sidebar {
                width: 260px;
                height: 100vh;
                overflow-y: auto;
            }
            
            .sidebar-nav {
                overflow-y: auto;
                flex-grow: 1;
                min-height: 0;
                max-height: calc(100vh - 140px);
            }
            
            .nav-link {
                padding: 0.5rem 1.5rem;
            }
            
            .profile-section {
                padding: 0.6rem;
                flex-shrink: 0;
                margin-top: auto;
            }

            .logout-btn {
                padding: 0.5rem;
                font-size: 0.75rem;
            }
            
            .sidebar-header {
                padding: 0.75rem;
                flex-shrink: 0;
            }
        }

        /* Animation d'ouverture/fermeture améliorée */
        @media (max-width: 767px) {
            .sidebar {
                transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            }
        }

        /* Accessibilité - Focus states */
        .toggle-sidebar:focus,
        .sidebar-collapse-btn:focus,
        .nav-link:focus {
            outline: 2px solid #5E60CE;
            outline-offset: 2px;
        }

        /* États de chargement */
        .sidebar.loading {
            pointer-events: none;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bouton pour afficher/masquer la sidebar en mobile -->
    <button class="toggle-sidebar" id="toggleSidebar" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Bouton pour réduire/agrandir la sidebar (desktop uniquement) -->
        <div class="sidebar-collapse-btn" id="sidebarCollapseBtn" aria-label="Collapse sidebar">
            <i class="fas fa-chevron-left"></i>
        </div>

        <!-- En-tête de la sidebar -->
        <div class="sidebar-header">
            <i class="fas fa-user-shield mr-2"></i> <span>Espace Admin</span>
        </div>
        
        <!-- Navigation -->
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tableau-de-bord') ? 'active' : '' }}" href="{{ route('admin.tableau-de-bord') }}">
                        <i class="fas fa-tachometer-alt"></i> <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                        <i class="fas fa-exclamation-triangle"></i> <span>Signalements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.supports.*') ? 'active' : '' }}" href="{{ route('admin.supports.index') }}">
                        <i class="fas fa-folder"></i> <span>Supports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}" href="{{ route('admin.questions.index') }}">
                        <i class="fas fa-comments"></i> <span>Forum</span>
                    </a>
                </li>

                {{-- consultation --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}" href="{{ route('admin.consultations') }}">
                        <i class="fas fa-chart-bar text-sm"></i> <span>Consultations</span>
                    </a>
                </li>
                
                <div class="menu-separator"></div>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('filiere.*') ? 'active' : '' }}" href="{{ route('filiere.index') }}">
                        <i class="fas fa-graduation-cap"></i> <span>Filières</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('matiere.*') ? 'active' : '' }}" href="{{ route('matiere.index') }}">
                        <i class="fas fa-book"></i> <span>Matières</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                        <i class="fas fa-users"></i> <span>Utilisateurs</span>
                    </a>
                </li>
                
                <div class="menu-separator"></div>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">
                        <i class="fas fa-bell"></i> <span>Notifications</span>
                        @isset($unreadCount)
                            @if($unreadCount > 0)
                                <span class="badge-notification">{{ $unreadCount }}</span>
                            @endif
                        @endisset
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-edit"></i> <span>Gestion Profil</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Section profil -->
        <div class="profile-section">
            <div class="profile-content">
                <div class="profile-avatar">
                    @php
                        $prenom = auth()->user()->prenom;
                        $nom = auth()->user()->nom;
                        $initials = strtoupper(substr($prenom, 0, 1)) . strtoupper(substr($nom, 0, 1));
                    @endphp
                    {{ $initials }}
                </div>
                <div class="profile-info">
                    <p class="profile-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                    <p class="profile-role">Administrateur</p>
                </div>
            </div>
            
            <!-- Section déconnexion intégrée -->
            <div class="logout-section">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        @yield('content')
    </div>

    @yield('scripts')

    {{-- script vite pour echo --}}
    @vite('resources/js/app.js')

    <script>
        // Script amélioré pour la gestion responsive de la sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            const overlay = document.getElementById('sidebarOverlay');
            
            let isDesktop = window.innerWidth > 767;
            
            // Fonction pour détecter le type d'écran
            function updateScreenType() {
                const newIsDesktop = window.innerWidth > 767;
                if (newIsDesktop !== isDesktop) {
                    isDesktop = newIsDesktop;
                    // Réinitialiser l'état de la sidebar lors du changement de breakpoint
                    if (isDesktop) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                        document.body.style.overflow = '';
                    } else {
                        sidebar.classList.remove('collapsed');
                    }
                }
            }
            
            // Toggle pour mobile
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                
                // Empêcher le scroll du body quand la sidebar est ouverte en mobile
                if (sidebar.classList.contains('show')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
            
            // Réduire/agrandir la sidebar (desktop uniquement)
            collapseBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (isDesktop) {
                    sidebar.classList.toggle('collapsed');
                    
                    // Sauvegarder l'état dans localStorage
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                }
            });
            
            // Fermer la sidebar avec l'overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            });
            
            // Fermer la sidebar avec la touche Échap
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && sidebar.classList.contains('show') && !isDesktop) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            
            // Gestion du redimensionnement de la fenêtre
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    updateScreenType();
                }, 150);
            });
            
            // Fermer la sidebar quand on clique sur un lien en mobile
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (!isDesktop && sidebar.classList.contains('show')) {
                        setTimeout(() => {
                            sidebar.classList.remove('show');
                            overlay.classList.remove('show');
                            document.body.style.overflow = '';
                        }, 100);
                    }
                });
            });
            
            // Restaurer l'état de la sidebar depuis localStorage (desktop uniquement)
            if (isDesktop) {
                const savedState = localStorage.getItem('sidebarCollapsed');
                if (savedState === 'true') {
                    sidebar.classList.add('collapsed');
                }
            }
            
            // Amélioration des performances avec throttle pour les événements de scroll
            let ticking = false;
            function updateScrollState() {
                // Logique pour gérer le scroll si nécessaire
                ticking = false;
            }
            
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateScrollState);
                    ticking = true;
                }
            });
            
            // Support pour les gestes tactiles (swipe) sur mobile
            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            
            document.addEventListener('touchstart', function(e) {
                if (!isDesktop) {
                    startX = e.touches[0].clientX;
                    isDragging = true;
                }
            }, { passive: true });
            
            document.addEventListener('touchmove', function(e) {
                if (!isDesktop && isDragging) {
                    currentX = e.touches[0].clientX;
                }
            }, { passive: true });
            
            document.addEventListener('touchend', function(e) {
                if (!isDesktop && isDragging) {
                    const diffX = currentX - startX;
                    const threshold = 50;
                    
                    // Swipe depuis le bord gauche pour ouvrir
                    if (startX < 20 && diffX > threshold && !sidebar.classList.contains('show')) {
                        sidebar.classList.add('show');
                        overlay.classList.add('show');
                        document.body.style.overflow = 'hidden';
                    }
                    // Swipe vers la gauche pour fermer
                    else if (diffX < -threshold && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                    
                    isDragging = false;
                }
            }, { passive: true });
            
            // Initialiser l'état de l'écran
            updateScreenType();
        });
    </script>
    
    @yield('scripts')
</body>
</html>