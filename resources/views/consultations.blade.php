@extends('layouts.professeur')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-6">Statistiques de consultation par type de support</h2>

    <div class="bg-white p-4 rounded-lg shadow">
        <canvas id="consultationChart"></canvas>
    </div>

    <div class="mt-8">
        @foreach($statistiques as $type => $supports)
            <h4 class="text-lg font-semibold mt-6 mb-2 text-indigo-700">{{ $type }}</h4>
            <div class="space-y-4">
                @foreach($supports as $support)
                    @foreach($support->consultations as $consultation)
                        <div class="bg-gray-100 p-4 rounded shadow-sm">
                            <p>
                                👤 <strong>{{ $consultation->user->nom }} {{ $consultation->user->prenom }}</strong>
                                a consulté <span class="text-indigo-600 font-semibold">"{{ $support->titre }}"</span>
                                ({{ $support->type->nom }}) dans la matière <strong>{{ $support->matiere->Nom ?? 'Inconnue' }}</strong>.
                            </p>
                            <p class="text-sm text-gray-500">Date : {{ $consultation->date_consultation }}</p>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection {{-- 👈 ceci manquait --}}

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('consultationChart').getContext('2d');

        const labels = @json($statistiques->keys()->toArray());
        const dataCounts = @json(
            $statistiques->map(function ($supports) {
                return $supports->sum('consultations_count');
            })->toArray()
        );

        const data = {
            labels: labels,
            datasets: [{
                label: 'Nombre total de consultations',
                data: dataCounts,
                backgroundColor: '#5E60CE',
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Consultations par type de support'
                    }
                }
            }
        };

        new Chart(ctx, config);
    });
</script>
@endsection