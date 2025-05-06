@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Tableau de bord</h1>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Étudiants -->
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.104 0 2 .896 2 2s-.896 2-2 2-2-.896-2-2 .896-2 2-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre d'étudiants</h2>
                    <p class="text-2xl">{{ $studentsCount }}</p>
                </div>
            </div>

            <!-- Professeurs -->
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l7 7 7-7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre de professeurs</h2>
                    <p class="text-2xl">{{ $professorsCount }}</p>
                </div>
            </div>

            <!-- Supports -->
            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 3h-4.586a1 1 0 0 0-.707.293L11 5.586 9.293 3.707A1 1 0 0 0 8 3H3a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre de supports</h2>
                    <p class="text-2xl">{{ $supportsCount }}</p>
                </div>
            </div>
        </div>

        <!-- GRAPHIQUES -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Diagramme à barres -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Répartition des utilisateurs</h3>
                <canvas id="barChart" style="height: 150px;"></canvas>
            </div>

            <!-- Diagramme circulaire -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Pourcentage des rôles</h3>
                <canvas id="pieChart" style="height: 100px;"></canvas>
            </div>
        </div>

        <!-- Nouveau graphique : Supports par matière -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Supports par matière</h3>
            <canvas id="matiereChart" style="height: 150px;"></canvas>
            {{-- canvas::est lespace reserver pour dessiner le graphiques avec chart js --}}
        </div>
    </div>
@endsection
{{-- partieeee javaa scrippt pour laffichage des donnes avec javascript --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const studentsCount = {{ $studentsCount }};
        const professorsCount = {{ $professorsCount }};
        const adminsCount = {{ $adminsCount }};

        // Graphique à barres : utilisateurs
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Étudiants', 'Professeurs', 'Administrateurs'],
                datasets: [{
                    label: 'Nombre total',
                    data: [studentsCount, professorsCount, adminsCount],
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B'],
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        // Graphique circulaire : rôles
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Étudiants', 'Professeurs', 'Administrateurs'],
                datasets: [{
                    data: [studentsCount, professorsCount, adminsCount],
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B']
                }]
            },
            options: {
                responsive: true
            }
        });

        // Graphique à barres horizontales : supports par matière
        const matiereLabels = {!! json_encode($supportsParMatiere->keys()) !!};
        const matiereData = {!! json_encode($supportsParMatiere->values()) !!};
        // json encodeee transpform les donnee php en tableau javascript
        // keys veut dire les noms ds matieres
        // value les nbrs de supports

        // ici on va commencer la creation des graphique
        const matiereCtx = document.getElementById('matiereChart').getContext('2d');
        new Chart(matiereCtx, {
            type: 'bar',
            data: {
                labels: matiereLabels,
                datasets: [{
                    label: 'Nombre de supports',
                    data: matiereData,
                    backgroundColor: '#6366F1'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endsection
{{-- withCount	Compter les supports pour chaque matière
     mapWithKeys	Formater les données pour le graphique
     json_encode	Envoyer les données PHP vers JavaScript
     Chart.js	Afficher un graphique interactif (barres horizontales)
    indexAxis: 'y'	Affiche les barres horizontalement --}}
