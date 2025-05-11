
    @extends('layouts.navbar')

@section('title', 'Résultats de Recherche')

@section('content')
    <div class="container">
        <h2>Résultats pour : "{{ $query }}"</h2>

        @if($results->isEmpty())
            <p>Aucun résultat trouvé.</p>
        @else
            <ul>
                @foreach($results as $result)
                    <li>{{ $result->nom }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
