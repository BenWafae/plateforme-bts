<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BTS AI Idrissi</title>

  <!-- Bootstrap 4 CSS -->
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-MD7pnLvYy+EYZxAo1d9fmi9z4kQdCcnZD9hxF7q0fRwRm0B1qv+kn/eELM5EJvBJ"
    crossorigin="anonymous"
  />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            violet: {
              custom: "#5E60CE",
            },
          },
        },
      },
    };
  </script>

  <!-- Correction CSS Pagination Bootstrap 4 pour cohabiter avec Tailwind -->
  <style>
    .pagination {
      display: flex !important;
      padding-left: 0 !important;
      margin-bottom: 1rem !important;
      list-style: none !important;
      border-radius: 0.25rem !important;
    }

    .page-item {
      margin-left: 0.25rem !important;
      margin-right: 0.25rem !important;
    }

    .page-link {
      position: relative !important;
      display: block !important;
      padding: 0.5rem 0.75rem !important;
      margin-left: -1px !important;
      line-height: 1.25 !important;
      color: #5e60ce !important;
      background-color: #fff !important;
      border: 1px solid #dee2e6 !important;
      border-radius: 0.25rem !important;
      text-decoration: none !important;
      cursor: pointer !important;
      user-select: none !important;
      transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
        border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
    }

    .page-link:hover {
      color: #4f51b8 !important;
      background-color: #e9ecef !important;
      border-color: #dee2e6 !important;
      text-decoration: none !important;
    }

    .page-item.active .page-link {
      z-index: 3 !important;
      color: #fff !important;
      background-color: #5e60ce !important;
      border-color: #5e60ce !important;
      cursor: default !important;
      box-shadow: 0 0 0 0.2rem rgba(94, 96, 206, 0.5) !important;
    }

    .page-item.disabled .page-link {
      color: #6c757d !important;
      pointer-events: none !important;
      cursor: auto !important;
      background-color: #fff !important;
      border-color: #dee2e6 !important;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col text-gray-800">
  <!-- NAVBAR -->
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo gauche -->
        <div class="flex items-center">
          <a href="/" class="flex items-center text-gray-800 font-bold text-lg">
            <i class="fas fa-graduation-cap text-violet-custom mr-2"></i>
            BTS AI Idrissi
          </a>
        </div>

        <!-- Liens centre -->
        <div class="hidden md:flex space-x-6 absolute left-1/2 transform -translate-x-1/2">
          <a href="{{ url('/') }}?type=cours" class="text-violet-custom font-semibold">Cours</a>
          <a href="{{ url('/') }}?type=exercices" class="text-gray-700 hover:text-violet-custom transition">Exercices</a>
          <a href="{{ url('/') }}?type=examens" class="text-gray-700 hover:text-violet-custom transition">Examens</a>

          <!-- Barre recherche -->
          <form action="{{ route('search.index') }}" method="GET" class="hidden md:block relative">
            <input
              type="text"
              name="q"
              placeholder="Rechercher..."
              class="border border-gray-300 rounded-full px-4 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-violet-custom"
            />
            <button
              type="submit"
              class="absolute right-1 top-1/2 transform -translate-y-1/2 text-violet-custom"
            >
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>

        <!-- Boutons droite -->
        <div class="flex items-center space-x-4">
          @auth
          <a
            href="{{ route('dashboard') }}"
            class="bg-violet-custom text-white px-4 py-2 rounded-md text-sm shadow hover:bg-[#4F51B8] transition"
            >Dashboard</a
          >
          @else
          <a
            href="{{ route('login') }}"
            class="bg-violet-custom text-white px-4 py-2 rounded-md text-sm shadow hover:bg-[#4F51B8] transition"
            >Connexion</a
          >
          <a
            href="{{ route('register') }}"
            class="bg-violet-custom text-white px-4 py-2 rounded-md text-sm shadow hover:bg-[#4F51B8] transition"
            >Inscription</a
          >
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Contenu principal -->
  <main class="flex-1 container mx-auto px-4 py-6">
    @yield('content')
  </main>

  <!-- Pied de page -->
  <footer class="text-center text-sm text-gray-500 py-4">
    © 2025 Plateforme BTS AI Idrissi - Tous droits réservés
  </footer>

  <!-- Font Awesome -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>
