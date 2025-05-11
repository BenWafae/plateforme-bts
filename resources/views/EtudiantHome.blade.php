@extends('layouts.navbar')

@section('title', 'home')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        padding: 20px;
    }

    h1 {
        font-size: 2.5em;
        text-align: center;
        color: #2A5298;
        margin-top: 10px;
    }

    p.intro {
        font-size: 1.2em;
        color: #444;
        text-align: center;
        margin-bottom: 40px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .alert-welcome {
        background: linear-gradient(90deg, #4e73df, #1cc88a);
        color: #fff;
        padding: 15px 25px;
        margin: 20px auto;
        border-radius: 10px;
        width: fit-content;
        text-align: center;
        font-size: 1.1em;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        animation: fadeInDown 0.5s ease-in-out;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
    }

    .card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        width: 250px;
        text-align: center;
        padding: 25px 15px;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .card-icon {
        font-size: 3em;
        color: #2A5298;
        margin-bottom: 15px;
        transition: transform 0.3s;
    }

    .card:hover .card-icon {
        transform: rotate(5deg) scale(1.1);
    }

    .card h3 {
        font-size: 1.4em;
        color: #333;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 0.95em;
        color: #666;
    }

    .footer-section {
        margin-top: 50px;
        padding: 20px;
        background-color: #2A5298;
        color: white;
        text-align: center;
        border-radius: 10px;
    }

    .footer-section a {
        color: #fff;
        text-decoration: underline;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .card {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .card {
            width: 100%;
        }
    }
</style>

<div class="container">
    @auth
        <div class="alert-welcome">
            Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ! Vous êtes maintenant connecté(e) à la plateforme BTS.
        </div>
    @endauth

    
    <p class="intro">
        Accédez rapidement à vos ressources pédagogiques selon votre niveau, matière et filière. Cliquez sur une carte pour explorer les contenus.
    </p>

    <div class="card-container">
        @php
            $cours = [
                ['title' => 'SEP', 'icon' => 'fas fa-cogs', 'desc' => "Systèmes d'exploitation propriétaires.", 'route' => '#'],
                ['title' => 'Python', 'icon' => 'fab fa-python', 'desc' => 'Ressources pour BTS.', 'route' => '#'],
                ['title' => 'Langage C', 'icon' => 'fas fa-code', 'desc' => 'TD et TP du langage C.', 'route' => '#'],
                ['title' => 'Merise', 'icon' => 'fas fa-database', 'desc' => 'Analyse avec Merise.', 'route' => '#'],
                ['title' => 'Mathématiques', 'icon' => 'fas fa-superscript', 'desc' => 'Maths appliquées.', 'route' => '#'],
                ['title' => 'SQL', 'icon' => 'fas fa-database', 'desc' => 'Bases de données et SQL.', 'route' => '#'],
                ['title' => 'Physique', 'icon' => 'fas fa-flask', 'desc' => 'Physique appliquée.', 'route' => '#'],
                ['title' => 'Réseau', 'icon' => 'fas fa-network-wired', 'desc' => 'Réseaux et protocoles.', 'route' => '#'],
                ['title' => 'Mécanique', 'icon' => 'fas fa-cogs', 'desc' => 'Mécanique appliquée.', 'route' => '#'],
                ['title' => 'Communication', 'icon' => 'fas fa-broadcast-tower', 'desc' => 'Communication.', 'route' => '#'],
                ['title' => 'Automatisation', 'icon' => 'fas fa-robot', 'desc' => 'Automatisme.', 'route' => '#'],
                ['title' => 'Industrielle', 'icon' => 'fas fa-industry', 'desc' => 'Mécanique industrielle.', 'route' => '#'],
                ['title' => 'Électricité', 'icon' => 'fas fa-bolt', 'desc' => 'Génie électrique.', 'route' => '#'],
            ];
        @endphp

        @foreach ($cours as $coursItem)
            <a href="{{ $coursItem['route'] }}" style="text-decoration: none;">
                <div class="card">
                    <div class="card-icon"><i class="{{ $coursItem['icon'] }}"></i></div>
                    <h3>{{ $coursItem['title'] }}</h3>
                    <p>{{ $coursItem['desc'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>

<div class="footer-section">
    <p>
        Contact : <a href="mailto:elgrafelfatima@gmail.com">elgrafelfatima@gmail.com</a>
    </p>
    <p>
        BTS Learn – Ressources pédagogiques pour les étudiant(e)s du BTS.
    </p>
    <p style="font-size: 0.8em; opacity: 0.8;">&copy; 2025 BTS Learn. Tous droits réservés.</p>
</div>
@endsection