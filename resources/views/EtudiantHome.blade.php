@extends('layouts.navbar')

@section('title', 'Accueil')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    :root {
        --primary: #2a5298;
        --accent: #1cc88a;
        --bg-light: #f0f2f5;
        --card-bg: #fff;
        --text-dark: #2c3e50;
        --text-light: #555;
        --shadow: rgba(0, 0, 0, 0.08);
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-light);
        margin: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    h1 {
        font-size: 2.5em;
        text-align: center;
        color: var(--text-dark);
        margin-bottom: 25px;
        font-weight: 700;
    }

    .alert-welcome {
        background: linear-gradient(90deg, #4e73df, #1cc88a);
        color: #fff;
        padding: 8px 16px;
        margin: 20px auto;
        border-radius: 6px;
        text-align: center;
        font-size: 0.95em;
        font-weight: 500;
        box-shadow: 0 2px 8px var(--shadow);
        max-width: 800px;
    }

    p.intro {
        text-align: center;
        color: var(--text-light);
        font-size: 1.05em;
        margin-bottom: 40px;
        max-width: 800px;
        line-height: 1.7;
        margin-left: auto;
        margin-right: auto;
    }

    .section-title {
        text-align: center;
        font-size: 1.8em;
        color: var(--primary);
        font-weight: 700;
        margin: 50px auto 20px;
        position: relative;
        padding-bottom: 8px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: -10px;
        width: 80px;
        height: 3px;
        background: linear-gradient(to right, #4e73df, #1cc88a);
        border-radius: 5px;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .card {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 6px 16px var(--shadow);
        padding: 20px 15px;
        text-align: center;
        transition: 0.3s ease;
        cursor: pointer;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }

    .card:hover {
        transform: translateY(-6px) scale(1.02);
        background-color: #f0f8ff;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    .card-icon {
        font-size: 2.5em;
        color: #1565c0;
        margin-bottom: 14px;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .card:hover .card-icon {
        transform: scale(1.2);
        color: #1e88e5;
    }

    .card h3 {
        font-size: 1.1em;
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .card p {
        font-size: 0.95em;
        color: var(--text-light);
        line-height: 1.4;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 992px) {
        h1 {
            font-size: 2.2em;
        }

        .card-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }

    @media (max-width: 600px) {
        h1 {
            font-size: 1.8em;
        }

        .section-title {
            font-size: 1.4em;
        }

        .card-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="card" style="margin-bottom: 30px; background: linear-gradient(135deg, #4e73df, #1cc88a); color: white; padding: 25px; text-align: center;">
    <h2 style="font-size: 1.8em; font-weight: 700; margin-bottom: 15px;">Plateforme BTS Al Idrissi</h2>

    @auth
        <p style="font-size: 1.1em; font-weight: 500; margin-bottom: 10px;">
            Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ! Vous êtes maintenant connecté(e) à la plateforme BTS.
        </p>
    @endauth

    <p style="font-size: 1em; line-height: 1.6; max-width: 700px; margin: 0 auto;">
        Explorez les matières principales enseignées dans les différentes filières BTS.<br>
        Pour accéder aux <strong>cours détaillés correspondant à votre filière</strong>, rendez-vous dans la page dédiée aux cours.
    </p>
</div>

    @php
        $filières = [
            'SRI – Systèmes et Réseaux Informatiques' => [
                ['title' => 'Architecture des systèmes informatiques', 'desc' => "Structure des ordinateurs et composants.", 'icon' => 'fas fa-microchip'],
                ['title' => 'Administration des réseaux', 'desc' => "Mise en place et gestion de réseaux IP, DNS, DHCP.", 'icon' => 'fas fa-network-wired'],
                ['title' => 'Sécurité informatique', 'desc' => "Protection des données et des systèmes.", 'icon' => 'fas fa-shield-alt'],
                ['title' => 'Virtualisation', 'desc' => "Machines virtuelles.", 'icon' => 'fas fa-cloud'],
                ['title' => 'Programmation', 'desc' => "Langages C, Bash, scripts automatisés.", 'icon' => 'fas fa-code'],
                ['title' => 'Gestion de projet IT', 'desc' => "Méthodes Agile, cycle en V.", 'icon' => 'fas fa-project-diagram'],
                ['title' => 'Anglais', 'desc' => "Documentation et communication en anglais.", 'icon' => 'fas fa-language'],
                ['title' => 'Technique de communication', 'desc' => "Expression écrite et orale.", 'icon' => 'fas fa-pen']
            ],
            'ESA – Électronique et Systèmes Automatisés' => [
                ['title' => 'Électronique', 'desc' => "Circuits analogiques et numériques.", 'icon' => 'fas fa-bolt'],
                ['title' => 'Automatismes industriels', 'desc' => "Automates, GRAFCET, commandes.", 'icon' => 'fas fa-robot'],
                ['title' => 'Électrotechnique', 'desc' => "Transformateurs, moteurs, installations.", 'icon' => 'fas fa-plug'],
                ['title' => 'Informatique industrielle', 'desc' => "Microcontrôleurs, systèmes embarqués.", 'icon' => 'fas fa-microchip'],
                ['title' => 'Maintenance', 'desc' => "Diagnostic et dépannage de systèmes.", 'icon' => 'fas fa-tools'],
                ['title' => 'Mesures physiques', 'desc' => "Tension, courant, température, etc.", 'icon' => 'fas fa-thermometer-half'],
                ['title' => 'Anglais scientifique', 'desc' => "Vocabulaire technique.", 'icon' => 'fas fa-language'],
                ['title' => 'Mathématiques appliquées', 'desc' => "Calculs pour l’électronique et automatisme.", 'icon' => 'fas fa-square-root-alt']
            ],
            'PME – Petites et Moyennes Entreprises' => [
                ['title' => 'Relation client / fournisseur', 'desc' => "Commandes, devis, factures, fidélisation.", 'icon' => 'fas fa-handshake'],
                ['title' => 'Comptabilité', 'desc' => "Enregistrements, budget, suivi financier.", 'icon' => 'fas fa-calculator'],
                ['title' => 'Droit', 'desc' => "Contrats, législation du travail.", 'icon' => 'fas fa-balance-scale'],
                ['title' => 'Communication', 'desc' => "Outils professionnels internes et externes.", 'icon' => 'fas fa-comments'],
                ['title' => 'RH', 'desc' => "Salaires, congés, formation.", 'icon' => 'fas fa-users'],
                ['title' => 'Outils numériques', 'desc' => "ERP, Excel, logiciels de gestion.", 'icon' => 'fas fa-cogs'],
                ['title' => 'Économie / Management', 'desc' => "Fonctionnement de l’entreprise.", 'icon' => 'fas fa-chart-line'],
                ['title' => 'Anglais pro', 'desc' => "Utilisation professionnelle de l’anglais.", 'icon' => 'fas fa-language']
            ],
            'CPI – Conception de Produits Industriels' => [
                ['title' => 'Dessin / DAO / CAO', 'desc' => "Plans techniques (AutoCAD, SolidWorks).", 'icon' => 'fas fa-drafting-compass'],
                ['title' => 'Conception mécanique', 'desc' => "Pièces mécaniques et assemblage.", 'icon' => 'fas fa-cogs'],
                ['title' => 'Analyse fonctionnelle', 'desc' => "Étude des fonctions d’un produit.", 'icon' => 'fas fa-chart-bar'],
                ['title' => 'Méthodes de fabrication', 'desc' => "Usinage, moulage, procédés.", 'icon' => 'fas fa-industry'],
                ['title' => 'Production et qualité', 'desc' => "Contrôle qualité, organisation.", 'icon' => 'fas fa-check-circle'],
                ['title' => 'Physique appliquée', 'desc' => "Lois physiques et mécanique.", 'icon' => 'fas fa-atom'],
                ['title' => 'Mathématiques techniques', 'desc' => "Calculs de dimensionnement.", 'icon' => 'fas fa-square-root-alt'],
                ['title' => 'Anglais technique', 'desc' => "Documents techniques en anglais.", 'icon' => 'fas fa-language']
            ]
        ];
    @endphp

    @foreach ($filières as $filiereTitre => $matieres)
        <div>
            <h2 class="section-title">{{ $filiereTitre }}</h2>
            <div class="card-grid">
                @foreach ($matieres as $matiere)
                    <div class="card" tabindex="0" role="button" aria-label="{{ $matiere['title'] }}">
                        <div class="card-icon"><i class="{{ $matiere['icon'] }}"></i></div>
                        <h3>{{ $matiere['title'] }}</h3>
                        <p>{{ $matiere['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection