<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Administrateur')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- lien bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Lien CDN FontAwesome pour les icônes --}}
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <style>
        body {
            display: flex;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #BDC3C7;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar h2 {
            text-align: center;
            padding: 15px;
            background: #BDC3C7;
            margin: 0;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            padding: 15px;
            border-bottom: 1px solid #34495e;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .sidebar ul li:hover {
            background: #95a5a6;
        }
        .sidebar ul li ul {
            display: none;
            background: #34495e;
        }
        .sidebar ul li:hover ul {
            display: block;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        /* Responsive Design pour les petits écrans */
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
        <h2>Espace Admin</h2>
        <ul>
            <li><a href="#">Tableau de bord</a></li>
            <li>
                <a href="#">Formulaires</a>
                <ul>
                    {{-- <li><a href="{{ route('filiere.form') }}">Form Filière</a></li>
                    <li><a href="{{ route('matiere.form') }}">Form Matière</a></li> --}}
                    {{-- <li><a href="{{  route('user.form')}}">Form users</a></li> --}}
                   
                    <li><a href="#">Form Support</a></li>
                    
                </ul>
            </li>
            <li><a href="{{ route('filiere.index') }}">Filieres</a></li>
            <li><a href="{{ route('matiere.index') }}">Matiere</a></li> 
            <li><a href="{{ route('user.index') }}">Users</a></li>
            <li><a href="#">Notifications</a></li>
            <li><a href="#">Supports</a></li>
            <li>
                {{-- button deconnexion --}}
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                     <button type="submit" class="btn  btn-sm" title="Se déconnecter"> -
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>










































    







































    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
