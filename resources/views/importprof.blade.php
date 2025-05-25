@extends('layouts.professeur')

@section('content')
<style>
    body {
        background-color: #f5f9ff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
        max-width: 900px;
        margin: 40px auto;
        background: white;
        border-radius: 8px;
        padding: 30px 40px;
        box-shadow: 0 4px 15px rgba(0, 82, 204, 0.15);
        color: #0d47a1;
    }
    h2, h3 {
        color: #084298;
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
    }
    label {
        font-weight: 600;
        color: #0d47a1;
    }
    input[type="file"] {
        border: 1px solid #a3c0f9;
        padding: 8px 12px;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
        color: #084298;
        font-weight: 600;
        transition: border-color 0.3s ease;
    }
    input[type="file"]:hover {
        border-color: #1565c0;
    }
    button {
        background-color: #1565c0;
        border: none;
        color: white;
        padding: 12px 28px;
        font-size: 16px;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        margin-top: 15px;
        box-shadow: 0 3px 8px rgba(21, 101, 192, 0.5);
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #0d3c78;
    }
    .alert-success {
        background-color: #d0e9ff;
        color: #084298;
        border: 1px solid #1565c0;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
        text-align: center;
        font-weight: 600;
    }
    .alert-warning {
        background-color: #fff4e5;
        color: #7a5200;
        border: 1px solid #ffb300;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
        text-align: center;
        font-weight: 600;
    }
    .alert-error {
        background-color: #fdecea;
        color: #b00020;
        border: 1px solid #d32f2f;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
        font-weight: 600;
    }
    ul {
        padding-left: 20px;
        margin: 0;
    }
    .manual-file {
        border: 1px solid #1565c0;
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 8px;
        background-color: #e8f0fe;
    }
    .manual-file strong {
        display: block;
        margin-bottom: 12px;
        font-size: 18px;
        color: #0d47a1;
    }
    select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #a3c0f9;
        border-radius: 5px;
        font-weight: 600;
        color: #084298;
        margin-bottom: 15px;
        transition: border-color 0.3s ease;
    }
    select:focus {
        border-color: #1565c0;
        outline: none;
    }
</style>

<div class="container">

    <h2>Importer un dossier de supports</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire import principal --}}
    <form action="{{ route('professeur.support.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
        @csrf

        <label for="dossier_supports">Sélectionnez un dossier complet :</label>
        <input type="file" name="dossier_supports[]" id="dossier_supports" multiple webkitdirectory directory />

        <button type="submit">Importer</button>
    </form>

    {{-- Si fichiers non détectés, afficher formulaire manuel --}}
    @if(!empty($nonDetectes))
        <hr>
        <h3>Fichiers non détectés, merci de choisir leur type et matière :</h3>

        <form action="{{ route('professeur.support.validerImportManuel') }}" method="POST" id="manualForm">
            @csrf

            @foreach($nonDetectes as $index => $fichier)
                <div class="manual-file">
                    <strong>{{ $fichier['nom'] }}</strong>

                    <input type="hidden" name="fichiers[{{ $index }}][nom]" value="{{ $fichier['nom'] }}">
                    <input type="hidden" name="fichiers[{{ $index }}][chemin]" value="{{ $fichier['chemin'] }}">

                    <label for="type_{{ $index }}">Type :</label>
                    <select name="fichiers[{{ $index }}][type_id]" id="type_{{ $index }}" required>
                        <option value="">--Choisir--</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id_type }}">{{ $type->nom }}</option>
                        @endforeach
                    </select>

                    <label for="matiere_{{ $index }}">Matière :</label>
                    <select name="fichiers[{{ $index }}][matiere_id]" id="matiere_{{ $index }}" required>
                        <option value="">--Choisir--</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_Matiere }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            <button type="submit">Valider les choix manuels</button>
        </form>
    @endif

</div>
@endsection
