@extends('layouts.admin')

@section('content')
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
    </style>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Tableau de bord</h1>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Étudiants -->
            <div class="bg-gradient-to-r from-violet-custom to-purple-600 text-white p-6 rounded-lg shadow-lg flex items-center transform hover:scale-105 transition-transform duration-200">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre d'étudiants</h2>
                    <p class="text-2xl font-bold">{{ $studentsCount }}</p>
                </div>
            </div>

            <!-- Professeurs -->
            <div class="bg-gradient-to-r from-indigo-500 to-violet-custom text-white p-6 rounded-lg shadow-lg flex items-center transform hover:scale-105 transition-transform duration-200">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre de professeurs</h2>
                    <p class="text-2xl font-bold">{{ $professorsCount }}</p>
                </div>
            </div>

            <!-- Supports -->
            <div class="bg-gradient-to-r from-purple-500 to-violet-custom text-white p-6 rounded-lg shadow-lg flex items-center transform hover:scale-105 transition-transform duration-200">
                <div class="mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Nombre de supports</h2>
                    <p class="text-2xl font-bold">{{ $supportsCount }}</p>
                </div>
            </div>
        </div>

        <!-- Nouveau graphique : Supports par matière -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-chart-bar text-violet-custom mr-2"></i>
                Supports par matière
            </h3>
            <canvas id="matiereChart" style="height: 150px;"></canvas>
        </div>

        <!-- Nouveau graphique : Matières par filière -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-chart-line text-violet-custom mr-2"></i>
                Matières par filière
            </h3>
            <canvas id="filiereChart" style="height: 150px;"></canvas>
        </div>

        <!-- Derniers supports éducatifs -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-folder text-violet-custom mr-2"></i>
                Derniers supports éducatifs
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead class="bg-violet-50">
                        <tr>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Titre</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Matière</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Date d'ajout</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($derniersSupports as $support)
                            <tr class="hover:bg-violet-50 transition-colors duration-150">
                                <td class="py-3 px-4 border-b border-gray-200">{{ $support->titre }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $support->matiere->Nom ?? 'Inconnue' }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $support->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    @if (strpos($support->lien_url, '.pdf') !== false)
                                        <a href="{{ route('admin.support.showPdf', $support->id_support) }}" class="text-violet-custom hover:text-violet-700 transition-colors">
                                            <i class="fas fa-file-pdf text-lg"></i> 
                                        </a>
                                    @elseif (strpos($support->lien_url, '.docx') !== false || strpos($support->lien_url, '.pptx') !== false)
                                        <a href="{{ route('admin.support.showPdf', $support->id_support) }}" class="text-violet-custom hover:text-violet-700 transition-colors">
                                            <i class="fas fa-download text-lg"></i> 
                                        </a>
                                    @elseif (strpos($support->lien_url, 'youtube.com') !== false || strpos($support->lien_url, 'youtu.be') !== false)
                                        <a href="{{ $support->lien_url }}" target="_blank" class="text-red-600 hover:text-red-700 transition-colors">
                                            <i class="fab fa-youtube text-lg"></i> 
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Dernières questions posées -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-comments text-violet-custom mr-2"></i>
                Dernières questions posées
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead class="bg-violet-50">
                        <tr>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Titre</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Date</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Utilisateur</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dernièresQuestions as $question)
                            <tr class="hover:bg-violet-50 transition-colors duration-150">
                                <td class="py-3 px-4 border-b border-gray-200">{{ $question->titre }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ \Carbon\Carbon::parse($question->date_pub)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $question->user->nom }} {{ $question->user->prenom }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    <a href="{{ route('admin.questions.show', $question->id_question) }}" class="text-violet-custom hover:text-violet-700 transition-colors">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Derniers étudiants inscrits -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-t-4 border-violet-custom">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-user-graduate text-violet-custom mr-2"></i>
                Derniers étudiants inscrits
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead class="bg-violet-50">
                        <tr>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Nom</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Prénom</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Email</th>
                            <th class="py-3 px-4 border-b-2 border-violet-custom text-violet-custom font-semibold">Date d'inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($derniersEtudiants as $etudiant)
                            <tr class="hover:bg-violet-50 transition-colors duration-150">
                                <td class="py-3 px-4 border-b border-gray-200">{{ $etudiant->nom }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $etudiant->prenom }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $etudiant->email }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $etudiant->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Configuration des couleurs du thème
        const themeColors = {
            primary: '#5E60CE',
            secondary: '#7879E3',
            gradient: ['#5E60CE', '#7879E3', '#9B9EF0', '#B8BBFF']
        };

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
                    backgroundColor: themeColors.gradient,
                    borderColor: themeColors.primary,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: themeColors.primary,
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        precision: 0,
                        grid: {
                            color: 'rgba(94, 96, 206, 0.1)'
                        },
                        ticks: {
                            color: themeColors.primary
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(94, 96, 206, 0.1)'
                        },
                        ticks: {
                            color: themeColors.primary
                        }
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
                    backgroundColor: themeColors.gradient,
                    borderColor: themeColors.primary,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: themeColors.primary,
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        precision: 0,
                        grid: {
                            color: 'rgba(94, 96, 206, 0.1)'
                        },
                        ticks: {
                            color: themeColors.primary
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(94, 96, 206, 0.1)'
                        },
                        ticks: {
                            color: themeColors.primary
                        }
                    }
                }
            }
        });
    </script>
@endsection
