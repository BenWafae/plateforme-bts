<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTS AI Idrissi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .filter-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .filter-label {
            font-weight: 600;
            margin-right: 0.5rem;
            white-space: nowrap;
        }
        .resource-card {
            transition: all 0.3s;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .filter-label {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-graduation-cap me-2"></i>BTS AI Idrissi
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link {{ request('type') == 'cours' ? 'active fw-bold' : '' }}" 
                   href="?type=cours">Cours</a>
                <a class="nav-link {{ request('type') == 'exercices' ? 'active fw-bold' : '' }}" 
                   href="?type=exercices">Exercices</a>
                <a class="nav-link {{ request('type') == 'examens' ? 'active fw-bold' : '' }}" 
                   href="?type=examens">Examens</a>
            </div>
             <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Si l'utilisateur est connecté, affichez 'Dashboard' -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @else
                    <!-- Si l'utilisateur n'est pas connecté, affichez 'Login' et 'Sign Up' -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="text-center py-4 text-muted">
        © 2025 Plateforme BTS AI Idrissi - Tous droits réservés
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>