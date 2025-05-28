<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BTS AI Idrissi</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            violet: {
              custom: '#5E60CE'
            }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col text-gray-800">

  <!-- NAVBAR -->
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        
        <!-- Logo à gauche -->
        <div class="flex items-center">
          <a href="/" class="flex items-center text-gray-800 font-bold text-lg">
            <i class="fas fa-graduation-cap text-violet-custom mr-2"></i>
            BTS AI Idrissi
          </a>
        </div>

        <!-- Liens au centre -->
        <div class="hidden md:flex space-x-6 absolute left-1/2 transform -translate-x-1/2">
          <a href="{{ url('/') }}?type=cours" class="text-violet-custom font-semibold">Cours</a>
<a href="{{ url('/') }}?type=exercices" class="text-gray-700 hover:text-violet-custom transition">Exercices</a>
<a href="{{ url('/') }}?type=examens" class="text-gray-700 hover:text-violet-custom transition">Examens</a>

          <!-- Barre de recherche -->
<form action="{{ route('search.index') }}" method="GET" class="hidden md:block relative">
  <input 
    type="text" 
    name="q" 
    placeholder="Rechercher..." 
    class="border border-gray-300 rounded-full px-4 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-violet-custom"
  >
  <button type="submit" class="absolute right-1 top-1/2 transform -translate-y-1/2 text-violet-custom">
    <i class="fas fa-search"></i>
  </button>
</form>

        </div>

        <!-- Boutons à droite -->
        <div class="flex items-center space-x-4">
          @auth
            <a href="{{ route('dashboard') }}" class="bg-violet-custom text-white px-4 py-2 rounded-md text-sm shadow hover:bg-[#4F51B8] transition">
              Dashboard
            </a>
          @else
            <a href="{{ route('login') }}" class="bg-violet-custom text-white px-4 py-2 rounded-md text-sm shadow hover:bg-[#4F51B8] transition">
              Connexion
            </a>
            <a href="{{ route('register') }}" class="bg-violet-custom text-white px-4 py-2 rounded-md text-sm shadow hover:bg-[#4F51B8] transition">
              Inscription
            </a>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
