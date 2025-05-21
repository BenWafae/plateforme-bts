<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Tableau de bord étudiant')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f6f9;
      color: #333;
      transition: background-color 0.3s, color 0.3s;
      margin: 0;
    }

    .navbar {
      background-color: #002B5B;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 50px; /* plus d'espace entre les boutons */
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-size: 15px;
      font-weight: 500;
      text-transform: none;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .navbar a:hover {
      color: #ddd;
    }

    .right-section {
      display: flex;
      align-items: center;
      gap: 30px; /* espace entre dark mode et cercle */
    }

    .user-circle {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background-color: #C2185B; /* Gmail-like */
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: 600;
      font-size: 18px;
      cursor: pointer;
    }

    .dropdown-menu {
      right: 0;
      left: auto;
    }

    .dropdown:hover .dropdown-menu {
      display: block;
    }

    .dropdown-menu .dropdown-item {
      font-size: 14px;
      color: #002B5B;
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: #002B5B;
      color: white;
    }

    .notif-btn {
      position: relative;
      font-size: 15px;
    }

    .notif-btn .badge {
      position: absolute;
      top: -6px;
      right: -12px;
      font-size: 11px;
      background-color: red;
      color: white;
      padding: 3px 6px;
      border-radius: 50%;
    }

    .dark-toggle {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 18px;
    }

    .dark-mode {
      background-color: #1e1e1e;
      color: #e0e0e0;
    }

    .dark-mode .navbar {
      background-color: #111827;
    }

    .dark-mode .navbar a,
    .dark-mode .dark-toggle {
      color: #fff;
    }

    .dark-mode .dropdown-menu .dropdown-item {
      background-color: #1e1e1e;
      color: #fff;
    }

    .dark-mode .dropdown-menu .dropdown-item:hover {
      background-color: #374151;
    }

    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="nav-links">
      <a href="{{ route('etudiant.home') }}"><i class="fas fa-home"></i>Home</a>
      <a href="{{ route('etudiant.dashboard') }}"><i class="fas fa-book"></i>Cours</a>
      <a href="{{ route('forumetudiants.index') }}"><i class="fas fa-comments"></i>Forum</a>
      <a href="{{ route('notifications.index') }}" class="notif-btn">
        <i class="fas fa-bell"></i> Notifications
        @php
          $notif_count = App\Models\Notification::where('id_user', auth()->id())->where('lue', false)->count();
        @endphp
        @if($notif_count > 0)
          <span class="badge">{{ $notif_count }}</span>
        @endif
      </a>
    </div>

    <div class="right-section">
      <button class="dark-toggle" onclick="toggleDarkMode()" title="Mode sombre">
        <i class="fas fa-moon"></i>
      </button>

      <div class="dropdown">
        <div class="user-circle dropdown-toggle" data-bs-toggle="dropdown">
          {{ strtoupper(auth()->user()->prenom[0]) }}
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
              <i class="fas fa-user-cog me-2"></i>Gestion du profil
            </a>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="content">
    @yield('content')
  </div>

  <script>
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



  {{-- script vite pour echo --}}
@vite('resources/js/app.js')
</body>
</html>
