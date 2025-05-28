<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Tableau de bord étudiant')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


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
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 50px;
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
    color:rgb(224, 226, 234); 
}
  .right-section {
    display: flex;
    align-items: center;
    gap: 30px;
  }

  .user-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background-color:rgb(47, 85, 167); /* rouge vif */
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
    background-color:rgb(87, 88, 167);
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

  .dark-toggle {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 18px;
  }

  

  


  .content {
    padding: 20px;
  }
</style>

<nav class="navbar">
  <div class="nav-links">
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
    <form method="GET" action="{{ route('etudiant.dashboard') }}" class="d-flex align-items-center me-3" style="gap: 8px;">
  @if(request('annee'))
    <input type="hidden" name="annee" value="{{ request('annee') }}">
  @endif
  @if(request('filiere_id'))
    <input type="hidden" name="filiere_id" value="{{ request('filiere_id') }}">
  @endif
  @if(request('matiere_id'))
    <input type="hidden" name="matiere_id" value="{{ request('matiere_id') }}">
  @endif
  @if(request('type_id'))
    <input type="hidden" name="type_id" value="{{ request('type_id') }}">
  @endif

  <input class="form-control form-control-sm" type="search" name="search" placeholder="Rechercher un support..." value="{{ request('search') }}">
  <button class="btn btn-light btn-sm" type="submit"><i class="fas fa-search"></i></button>
</form>

  </div>



    <div class="dropdown">
      <div class="user-circle dropdown-toggle" data-bs-toggle="dropdown">
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
  </div>
</nav>


  <div class="content">
    @yield('content')
  </div>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>