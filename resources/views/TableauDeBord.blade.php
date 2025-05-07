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
        </div>

        <!-- Nouveau graphique : Matières par filière -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Matières par filière</h3>
            <canvas id="filiereChart" style="height: 150px;"></canvas>
        </div>

      <!-- Derniers supports ajoutés -->
<div class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Derniers supports ajoutés</h3>
    <table class="w-full text-left table-auto">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Matière</th>
                <th class="py-2 px-4 border-b">Support</th>
                <th class="py-2 px-4 border-b">Date d'ajout</th>
            </tr>
        </thead>
        <tbody>
            @foreach($derniersSupports as $support)
            <tr>
                <td class="py-2 px-4 border-b">{{ $support->matiere->Nom }}</td>
                <td class="py-2 px-4 border-b">{{ $support->titre }}</td>
                <td class="py-2 px-4 border-b">{{ $support->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Dernières questions posées -->
<div class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Dernières questions posées</h3>
    <table class="w-full text-left table-auto">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Titre</th>
                <th class="py-2 px-4 border-b">Date</th>
                <th class="py-2 px-4 border-b">Utilisateur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dernièresQuestions as $question)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $question->titre }}</td>
                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y') }}</td>
                    <td class="py-2 px-4 border-b">{{ $question->user->nom }} {{ $question->user->prenom }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Derniers étudiants inscrits -->
<div class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Derniers étudiants inscrits</h3>
    <table class="w-full text-left table-auto">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nom</th>
                <th class="py-2 px-4 border-b">Prénom</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Date d'inscription</th>
            </tr>
        </thead>
        <tbody>
            @foreach($derniersEtudiants as $etudiant)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $etudiant->nom }}</td>
                    <td class="py-2 px-4 border-b">{{ $etudiant->prenom }}</td>
                    <td class="py-2 px-4 border-b">{{ $etudiant->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $etudiant->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>




    </div>
@endsection

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

        // Nouveau graphique : matières par filière
        const filiereLabels = {!! json_encode($repartitionMatieresParFiliere->keys()) !!};
        const filiereData = {!! json_encode($repartitionMatieresParFiliere->values()) !!};
        const filiereCtx = document.getElementById('filiereChart').getContext('2d');
        new Chart(filiereCtx, {
            type: 'bar',
            data: {
                labels: filiereLabels,
                datasets: [{
                    label: 'Nombre de matières',
                    data: filiereData,
                    backgroundColor: '#FF6347'
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
