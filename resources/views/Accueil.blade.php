<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EduSchool') }}</title> <!-- Dynamique en fonction du nom de la plateforme dans .env -->
    <!-- Lien vers le CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">{{ config('app.name', 'EduSchool') }}</a> <!-- Nom dynamique -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Menu déroulant des filières -->
                
                <!-- Boutons Login et Sign Up -->
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                    {{-- {{ route('login') }} --}}
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sign Up</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenu de la page d'accueil -->
    <div class="container mt-5">
        <h1 class="text-center">Bienvenue sur EduSchool</h1>
        <p class="text-center">La plateforme éducative dédiée à notre école, où vous pouvez accéder à vos cours, ressources et gérer vos informations académiques.</p>
    </div>

    <!-- Lien vers le JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
