@extends('layouts.navbar')

@section('title', 'Accueil')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
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
        color: #2c3e50;
        margin-bottom: 25px;
        font-weight: 700;
    }

    .alert-welcome {
    background: linear-gradient(90deg, #4e73df, #1cc88a);
    color: #fff;
    padding: 8px 16px; /* Réduit la hauteur */
    margin: 20px auto;
    border-radius: 6px;
    text-align: center;
    font-size: 0.95em; /* Réduction de la taille de police */
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    max-width: 800px; /* Moins large que 90% */
}


    p.intro {
        text-align: center;
        color: #444;
        font-size: 1.05em;
        margin-bottom: 40px;
        max-width: 800px;
        line-height: 1.7;
        margin-left: auto;
        margin-right: auto;
    }

    .section-title {
        text-align: center;
        font-size: 1.6em;
        color: #2a5298;
        font-weight: 600;
        margin: 50px auto 20px;
        position: relative;
        padding-bottom: 8px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 0;
        width: 60px;
        height: 4px;
        background-color: #2a5298;
        border-radius: 6px;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
        padding: 20px 15px;
        text-align: center;
        transition: 0.3s ease;
        cursor: pointer;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card:hover {
        transform: translateY(-6px);
        background-color: #f1f6ff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-icon {
        font-size: 2.5em;
        color: #1565c0;
        margin-bottom: 14px;
    }

    .card h3 {
        font-size: 1.1em;
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .card p {
        font-size: 0.95em;
        color: #555;
        line-height: 1.4;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 2em;
        }

        .section-title {
            font-size: 1.3em;
        }

        .card-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }

        .card-icon {
            font-size: 2em;
        }
    }
</style>

<div class="container">
    <h1>Plateforme BTS Al Idrissi</h1>

    @auth
        <div class="alert-welcome">
            Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ! Vous êtes maintenant connecté(e) à la plateforme BTS.
        </div>
    @endauth

    <p class="intro">
        Explorez les matières principales enseignées dans les différentes filières BTS.<br>
        Pour accéder aux <strong>cours détaillés correspondant à votre filière</strong>, rendez-vous dans la page dédiée aux cours.<br>
    </p>

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
