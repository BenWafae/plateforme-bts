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
    {{-- Chart.js CDN (à ajouter dans layouts.admin)  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    
    <style>
     body {
    display: flex;
    margin: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    overflow: auto; /* Scroll activé pour le reste de la page */
}

.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2c3e50;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding-bottom: 20px;
    overflow: hidden; /* Désactive le scroll uniquement pour la sidebar */
}

.sidebar h2 {
    text-align: center;
    padding: 15px;
    background: #34495e;
    font-size: 20px;
    font-weight: bold;
    margin: 0;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 12px 20px;
    font-size: 16px;
}

.sidebar ul li a i {
    margin-right: 10px;
}

.sidebar ul li:hover {
    background: #1abc9c;
}

.profile-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    padding-left: 5px;
}

.profile-circle {
    width: 50px;
    height: 50px;
    background-color: #1abc9c;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 22px;
    font-weight: bold; 
    margin-left: -20px;
}

.content {
    margin-left: 250px;
    padding: 20px;
    width: calc(100% - 250px);
}

.btn-logout {
    display: flex;
    align-items: center;
    width: 100%;
    background: none;
    border: none;
    color: white;
    text-align: left;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
}

.btn-logout i {
    margin-right: 10px;
}

.btn-logout:hover {
    background: #e74c3c;
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .content {
        margin-left: 0;
        width: 100%;
    }
}
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <h2>Espace Admin</h2>
            <ul>
                <li><a href="{{ route('admin.tableau-de-bord') }}"><i class="fas fa-home"></i> Tableau de bord</a></li>
                <li><a href="{{ route('admin.reports.index') }}"><i class="fas fa-exclamation-triangle"></i> Signalements</a></li>
                <li><a href="{{ route('admin.supports.index') }}"><i class="fas fa-folder"></i> Supports</a></li>
                <li><a href="{{ route('admin.questions.index') }}"><i class="fas fa-comments"></i> Forum</a></li>
                <li><a href="{{ route('filiere.index') }}"><i class="fas fa-graduation-cap"></i> Filières</a></li>
                <li><a href="{{ route('matiere.index') }}"><i class="fas fa-book"></i> Matières</a></li>
                <li><a href="{{ route('user.index') }}"><i class="fas fa-users"></i> Utilisateurs</a></li>
               
          <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.notifications.index') }}">
        <i class="fas fa-bell"></i>
        @isset($unreadCount)
            @if($unreadCount > 0)
                <span class="badge bg-danger">{{ $unreadCount }}</span>
            @endif
        @endisset
        Notifications
    </a>
</li>









                <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user-edit"></i> Gestion Profil</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="profile-section">
            <div class="profile-circle">
                @php
                    $prenom = auth()->user()->prenom;
                    $nom = auth()->user()->nom;
                    $initials = strtoupper(substr($prenom, 0, 1)) . strtoupper(substr($nom, 0, 1));
                @endphp
                {{ $initials }}
            </div>
            <p>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
        </div>
    </div>
    <div class="content">
        @yield('content')
    </div>
    @yield('scripts')



    {{-- script vite pour echo --}}
@vite('resources/js/app.js')

</body>
</html>












































    







































    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
