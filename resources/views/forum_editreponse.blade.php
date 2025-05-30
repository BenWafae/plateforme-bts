
@extends('layouts.navbar')

@section('title', 'Modifier la réponse')

@section('content')
<style>
    body {
        background-color: #f4f6fc;
    }

    .btn-violet {
        background-color: #7879E3;
        color: white;
        border: none;
    }

    .btn-violet:hover {
        background-color: #5f60c7;
    }

    .text-violet {
        color: #7879E3;
    }

    .border-violet {
        border-color: #7879E3 !important;
    }

    .card-violet {
        border: 2px solid #7879E3;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(120, 121, 227, 0.2);
    }

    .card-header-violet {
        background-color: #7879E3;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-weight: 600;
    }
</style>

<div class="container py-5">
    <div class="card card-violet shadow-sm rounded-4">
        <div class="card-header card-header-violet">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Modifier votre réponse</h5>
        </div>
        <div class="card-body bg-white">
            <form action="{{ route('reponse.update', $reponse->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="contenu" class="form-label fw-semibold text-violet">Contenu de la réponse</label>
                    <textarea name="contenu" id="contenu" class="form-control rounded-3 border-violet @error('contenu') is-invalid @enderror" rows="5" required>{{ old('contenu', $reponse->contenu) }}</textarea>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('forumetudiants.index') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-violet rounded-pill">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
