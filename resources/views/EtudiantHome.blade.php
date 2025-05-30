@extends('layouts.navbar')

@section('title', 'Accueil')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 bg-gray-50 min-h-screen">

  <div class="text-white rounded-xl p-10 text-center shadow-lg mb-12" style="background-color:rgb(109, 111, 225);">
    <h2 class="text-3xl font-extrabold mb-4">Plateforme BTS Al Idrissi</h2>
    @auth
      <p class="text-lg font-semibold mb-3">
        Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ! Vous êtes maintenant connecté(e) à la plateforme BTS.
      </p>
    @endauth
    <p class="max-w-3xl mx-auto text-base leading-relaxed">
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
    <section class="mb-16">
      <h2 class="text-3xl font-extrabold text-center mb-8 border-b-4 inline-block pb-2"
          style="color: rgb(109, 111, 225); border-color: rgb(109, 111, 225);">
        {{ $filiereTitre }}
      </h2>
      <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($matieres as $matiere)
          <article tabindex="0" role="button" aria-label="{{ $matiere['title'] }}"
            class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center text-center cursor-pointer transition-transform transform hover:-translate-y-2 hover:scale-105 duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300">
            <div class="text-5xl mb-4 transition-colors duration-300"
                 style="color: rgb(109, 111, 225);"
                 onmouseover="this.style.color='rgb(129,131,235)';"
                 onmouseout="this.style.color='rgb(109,111,225)';">
              <i class="{{ $matiere['icon'] }}"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2"
                style="color: rgb(109, 111, 225);">
              {{ $matiere['title'] }}
            </h3>
            <p class="text-gray-600 text-sm">{{ $matiere['desc'] }}</p>
          </article>
        @endforeach
      </div>
    </section>
  @endforeach

</div>
@endsection
