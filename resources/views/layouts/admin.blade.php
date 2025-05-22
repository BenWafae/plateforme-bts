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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'violet-custom': '#5E60CE',
                    }
                }
            }
        }
    </script>
    
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
            overflow-y: hidden;
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

        /* Section profil */
        .profile-section {
            padding: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #F9FAFB;
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
            justify-content: center;
        }

        .sidebar.collapsed .profile-content {
            justify-content: center;
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

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .content {
                margin-left: 0;
                width: 100%;
            }
            
            .toggle-sidebar {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1001;
                background-color: #5E60CE;
                color: white;
                border: none;
                border-radius: 0.25rem;
                padding: 0.5rem;
                cursor: pointer;
            }
        }

        /* Bouton toggle sidebar (visible uniquement en mobile) */
        .toggle-sidebar {
            display: none;
        }

        /* Animation pour les transitions */
        .sidebar, .content {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Bouton pour afficher/masquer la sidebar en mobile -->
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Bouton pour réduire/agrandir la sidebar -->
        <div class="sidebar-collapse-btn" id="sidebarCollapseBtn">
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
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-left border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                        </button>
                    </form>
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
        // Script pour le toggle de la sidebar en responsive
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            
            // Toggle pour mobile
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
            
            // Réduire/agrandir la sidebar
            collapseBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
            
            // Fermer la sidebar quand on clique en dehors (mobile uniquement)
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggleBtn = toggleBtn.contains(event.target);
                const isClickOnCollapseBtn = collapseBtn.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggleBtn && !isClickOnCollapseBtn && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>














































    







































    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
