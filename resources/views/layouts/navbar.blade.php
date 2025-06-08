<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>@yield('title', 'Tableau de bord étudiant')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f6f9;
      color: #333;
      transition: background-color 0.3s, color 0.3s;
      margin: 0;
    }

    .navbar {
      background-color: #7879E3;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      flex-wrap: wrap;
      gap: 10px;
    }

    /* Bouton hamburger visible uniquement mobile */
    #btn-hamburger {
      background: transparent;
      border: none;
      color: white;
      cursor: pointer;
      display: none; /* caché desktop */
    }

    /* Afficher bouton hamburger sur petits écrans */
    @media (max-width: 767.98px) {
      #btn-hamburger {
        display: block;
      }
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 50px;
      flex-wrap: wrap;
    }

    /* Cacher menu nav-links par défaut sur mobile */
    @media (max-width: 767.98px) {
      .nav-links {
        display: none;
        flex-direction: column;
        gap: 15px;
        width: 100%;
        margin-top: 10px;
      }
      .nav-links.show {
        display: flex;
      }
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-size: 17px;
      font-weight: 600;
      text-transform: none;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: color 0.3s;
    }

    .navbar a:hover {
      color: rgb(224, 226, 234);
    }

    .user-circle {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background-color: rgb(47, 85, 167);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: 700;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .user-circle:hover {
      background-color: rgb(87, 88, 167);
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
      color: #0d3b66;
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: #0d3b66;
      color: white;
    }

    .notif-btn {
      position: relative;
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .notif-btn .badge {
      position: absolute;
      top: -6px;
      right: -12px;
      font-size: 11px;
      background-color: #d90429;
      color: white;
      padding: 3px 6px;
      border-radius: 50%;
    }

    .content {
      padding: 20px;
    }
  </style>
</head>
<body>

<nav class="navbar">

  <!-- Bouton hamburger pour mobile -->
  <button id="btn-hamburger" aria-label="Menu" aria-expanded="false" aria-controls="nav-links">
    <i class="fas fa-bars fa-lg"></i>
  </button>

  <div class="nav-links" id="nav-links">
    <a href="{{ route('etudiant.home') }}">
      <i class="fas fa-user-graduate"></i> Espace étudiant
    </a>
    <a href="{{ route('etudiant.dashboard') }}"><i class="fas fa-book"></i> Cours</a>
    <a href="{{ route('forumetudiants.index') }}"><i class="fas fa-comments"></i> Forum</a>
    <a class="nav-link" href="{{ route('questions.create') }}">
      <i class="fas fa-question-circle me-1"></i> Poser une question
    </a>
    <a href="{{ route('notifications.index') }}" class="notif-btn">
      <i class="fas fa-bell"></i> Notifications
      @php
        $notif_count = App\Models\Notification::where('id_user', auth()->id())->where('lue', false)->count();
      @endphp
      @if($notif_count > 0)
        <span class="badge">{{ $notif_count }}</span>
      @endif
    </a>

    <!-- Barre de recherche stylée blanche -->
    <form method="GET" action="{{ route('supports.recherche') }}" class="d-flex" style="gap: 6px; max-width: 280px; align-items: center; margin: 0;">
      <input
        class="form-control form-control-sm"
        type="search"
        name="search"
        placeholder="Rechercher un support..."
        value="{{ request('search') }}"
        autocomplete="off"
        style="
          height: 38px;
          border-radius: 20px;
          border: 1px solid #ccc;
          background-color: white;
          color: #333;
          padding-left: 15px;
          box-shadow: 0 1px 5px rgb(0 0 0 / 0.1);
          transition: border-color 0.3s, box-shadow 0.3s;
          font-size: 14px;
        "
        onfocus="this.style.borderColor='#7879E3'; this.style.boxShadow='0 0 8px rgba(120, 121, 227, 0.5)';"
        onblur="this.style.borderColor='#ccc'; this.style.boxShadow='0 1px 5px rgb(0 0 0 / 0.1)';"
      >
      <button
        class="btn btn-primary btn-sm"
        type="submit"
        aria-label="Rechercher"
        style="
          height: 38px;
          width: 38px;
          border-radius: 50%;
          padding: 0;
          display: flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 2px 6px rgb(120 121 227 / 0.4);
          transition: background-color 0.3s, box-shadow 0.3s;
          font-size: 16px;
        "
        onmouseover="this.style.backgroundColor='#5a5fdb'; this.style.boxShadow='0 4px 10px rgba(90, 95, 219, 0.7)';"
        onmouseout="this.style.backgroundColor=''; this.style.boxShadow='0 2px 6px rgb(120 121 227 / 0.4)';"
      >
        <i class="fas fa-search" style="color: white;"></i>
      </button>
    </form>
  </div>

  <div class="dropdown">
    <div class="user-circle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button" tabindex="0">
      {{ strtoupper(auth()->user()->prenom[0]) }}
    </div>
    <ul class="dropdown-menu dropdown-menu-end">
      <li>
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
          <i class="fas fa-user-cog me-2"></i> Gestion du profil
        </a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="dropdown-item">
            <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
          </button>
        </form>
      </li>
    </ul>
  </div>
</nav>

<div class="content">
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const btnHamburger = document.getElementById('btn-hamburger');
  const navLinks = document.getElementById('nav-links');

  btnHamburger.addEventListener('click', () => {
    const expanded = btnHamburger.getAttribute('aria-expanded') === 'true';
    btnHamburger.setAttribute('aria-expanded', !expanded);
    navLinks.classList.toggle('show');
  });
</script>

</body>
</html>