@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Statistiques des consultations</h2>

 

    <!-- Statistiques par matière -->
    <div class="mb-5">
        <h4>Consultations par matière</h4>
        <canvas id="graphConsultationsParMatiere" width="400" height="150"></canvas>
    </div>
    {{-- filtrage --}}

    <!-- Formulaire de filtrage par matière -->
<div class="mb-6">
    <form method="GET" action="{{ route('admin.consultations') }}" class="flex items-center gap-4">
        <div>
            <label for="matiere" class="block text-sm font-medium text-gray-700">Filtrer par matière</label>
            <select name="matiere" id="matiere" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                <option value="">Toutes les matières</option>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id_Matiere }}" {{ request('matiere') == $matiere->id_Matiere ? 'selected' : '' }}>
                        {{ $matiere->Nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-violet-custom text-white px-4 py-2 rounded hover:bg-violet-700">
                Filtrer
            </button>
        </div>
    </form>
</div>

   

    <!-- Liste des consultations -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-violet-custom to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center justify-between">
                <span class="flex items-center text-gray-800">
    <i class="fas fa-history mr-3"></i>
    Dernières consultations
</span>
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold text-dark">
    {{ $consultations->total() }} au total
</span>
            </h2>
        </div>

        <div class="p-6">
            @forelse($consultations as $consultation)
                <div class="list-item-hover flex flex-col lg:flex-row lg:items-center lg:justify-between p-4 rounded-xl border border-gray-100 mb-4 bg-gray-50">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-violet-custom to-indigo-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ strtoupper(substr($consultation->user->prenom, 0, 1)) }}{{ strtoupper(substr($consultation->user->nom, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $consultation->user->prenom }} {{ $consultation->user->nom }}
                                </h3>
                                <span class="badge-gradient text-white px-2 py-1 rounded-full text-xs">
                                    Étudiant
                                </span>
                            </div>

                            <p class="text-gray-700 mb-2">
                                a consulté 
                                <span class="font-semibold text-violet-custom">"{{ $consultation->support->titre }}"</span>
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <span class="inline-flex items-center">
                                    <i class="fas fa-tag mr-1 text-violet-custom"></i>
                                    {{ $consultation->support->type->nom }}
                                </span>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-book mr-1 text-violet-custom"></i>
                                    {{ $consultation->support->matiere->Nom ?? 'Matière non spécifiée' }}
                                </span>
                                <span class="inline-flex items-center">
                                    <i class="fas fa-clock mr-1 text-violet-custom"></i>
                                    {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-violet-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-violet-custom text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucune consultation</h3>
                    <p class="text-gray-600 mb-6">Aucune consultation n'a été enregistrée avec les filtres actuels.</p>
                    <a href="{{ route('consultations.index') }}" class="inline-flex items-center px-6 py-3 bg-violet-custom text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>
                        Réinitialiser les filtres
                    </a>
                </div>
            @endforelse

            @if($consultations->hasPages())
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600">
                            Affichage de <span class="font-semibold">{{ $consultations->firstItem() }}</span> à 
                            <span class="font-semibold">{{ $consultations->lastItem() }}</span> 
                            sur <span class="font-semibold">{{ $consultations->total() }}</span> consultations
                        </div>

                        <div class="pagination-custom">
                            @if ($consultations->onFirstPage())
                                <span class="page-link disabled">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $consultations->previousPageUrl() }}" class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            @foreach ($consultations->getUrlRange(1, $consultations->lastPage()) as $page => $url)
                                @if ($page == $consultations->currentPage())
                                    <span class="page-link active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($consultations->hasMorePages())
                                <a href="{{ $consultations->nextPageUrl() }}" class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="page-link disabled">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('graphConsultationsParMatiere')?.getContext('2d');

    if (ctx) {
        const consultationsData = {
            labels: {!! json_encode($consultationsParMatiere->keys()) !!},
            datasets: [{
                label: 'Nombre de consultations',
                data: {!! json_encode($consultationsParMatiere->values()) !!},
                backgroundColor: 'rgba(93, 135, 255, 0.7)',
                borderColor: 'rgba(93, 135, 255, 1)',
                borderWidth: 1
            }]
        };

        const chartOptions = {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        };

        new Chart(ctx, {
            type: 'bar',
            data: consultationsData,
            options: chartOptions
        });
    }
</script>
@endsection
