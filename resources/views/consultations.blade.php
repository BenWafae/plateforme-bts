@extends('layouts.professeur')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-6">Consultations par type de support et par semaine</h2>

   {{-- Filtrage par type de support --}}
<form method="GET" action="{{ route('consultations.index') }}" class="mb-6 flex flex-wrap items-center gap-4">
    {{-- Filtre par type --}}
    <label for="type" class="font-semibold text-gray-700">Type :</label>
    <select name="type" id="type" class="border rounded px-3 py-1">
        <option value="">Tous les types</option>
        @foreach($types as $type)
            <option value="{{ $type->id_type }}" {{ $selectedType == $type->id_type ? 'selected' : '' }}>
                {{ $type->nom }}
            </option>
        @endforeach
    </select>

    {{-- Filtre par matière --}}
    <label for="matiere" class="font-semibold text-gray-700">Matière :</label>
    <select name="matiere" id="matiere" class="border rounded px-3 py-1">
        <option value="">Toutes les matières</option>
        @foreach($matieres as $matiere)
            <option value="{{ $matiere->id_Matiere }}" {{ $selectedMatiere == $matiere->id_Matiere ? 'selected' : '' }}>
                {{ $matiere->Nom }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="px-4 py-1 bg-indigo-600 text-white rounded">Filtrer</button>
</form>


    {{-- Graphique des consultations --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <canvas id="consultationWeeklyChart"></canvas>
    </div>

   {{-- Liste paginée des consultations --}}
<div class="mt-8">
    <h4 class="text-lg font-semibold mt-6 mb-2 text-indigo-700">📋 Dernières consultations</h4>
    <div class="space-y-4">
        @forelse($consultations as $consultation)
            <div class="bg-gray-100 p-4 rounded shadow-sm">
                <p>
                    👤 <strong>{{ $consultation->user->nom }} {{ $consultation->user->prenom }}</strong>
                    a consulté <span class="text-indigo-600 font-semibold">"{{ $consultation->support->titre }}"</span>
                    ({{ $consultation->support->type->nom }}) dans la matière <strong>{{ $consultation->support->matiere->Nom ?? 'Inconnue' }}</strong>.
                </p>
                <p class="text-sm text-gray-500">Date : {{ $consultation->date_consultation }}</p>
            </div>
        @empty
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                <p>🚫 Aucune consultation enregistrée jusqu'à présent.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $consultations->links() }}
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('consultationWeeklyChart').getContext('2d');

        const labels = @json(array_keys($consultationsParSemaine)); // Types de support
        const semaines = @json(
            collect($consultationsParSemaine)
                ->flatten(2)
                ->pluck('date_consultation')
                ->map(fn($d) => \Carbon\Carbon::parse($d)->startOfWeek()->format('Y-m-d'))
                ->unique()
                ->sort()
                ->values()
                ->toArray()
        );

        const rawData = @json($consultationsParSemaine);

        const colors = [
            '#E0BBE4',
            '#D291BC',
            '#957DAD',
            '#7F6A93',
            '#5D4B75',
        ];

        const datasets = semaines.map((semaine, index) => {
            return {
                label: 'Semaine du ' + semaine,
                data: labels.map(type => {
                    const consultations = rawData[type]?.[semaine] ?? [];
                    return consultations.length;
                }),
                backgroundColor: colors[index % colors.length]
            };
        });

        const config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Consultations par type de support et par semaine'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const typeSupport = context[0].label;
                                return 'Type : ' + typeSupport;
                            },
                            label: function(context) {
                                const semaineLabel = context.dataset.label;
                                const count = context.raw;
                                return `${semaineLabel} - ${count} consultation${count > 1 ? 's' : ''}`;
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                }
            }
        };

        new Chart(ctx, config);
    });
</script>
@endsection
