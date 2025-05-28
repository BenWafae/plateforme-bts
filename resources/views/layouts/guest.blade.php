<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome pour les icônes -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
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

            /* Animation pour les éléments */
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            /* Effet de focus pour les inputs */
            .input-focus:focus {
                border-color: #5E60CE;
                box-shadow: 0 0 0 3px rgba(94, 96, 206, 0.1);
            }

            /* Animation de gradient */
            .gradient-animation {
                background: linear-gradient(-45deg, #5E60CE, #4F50AD, #6366f1, #8b5cf6);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Section gauche avec gradient -->
            <div class="hidden lg:flex lg:w-1/2 gradient-animation relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="relative z-10 flex flex-col justify-center items-center text-white p-12">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white bg-opacity-20 mb-8">
                            <i class="fas fa-graduation-cap text-4xl"></i>
                        </div>
                        <h1 class="text-4xl font-bold mb-4">Plateforme Éducative</h1>
                        <p class="text-xl opacity-90 max-w-md">
                            Connectez-vous pour accéder à votre espace personnel et gérer vos cours
                        </p>
                    </div>
                </div>
                <!-- Formes décoratives -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white bg-opacity-10 rounded-full -ml-20 -mb-20"></div>
            </div>

            <!-- Section droite avec formulaire -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-gray-50">
                <div class="w-full max-w-md">
                    <!-- Logo mobile -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-violet-custom to-indigo-700 text-white mb-4">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                    </div>

                    <!-- Contenu du formulaire -->
                    <div class="card-hover bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="p-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
