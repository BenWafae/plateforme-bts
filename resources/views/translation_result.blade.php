@extends('layouts.navbar')

@section('title', 'Résultat de traduction')

@section('content')
<div class="container mt-4">
  <h3>Traduction du support : {{ $support->titre }}</h3>

  <p>
    <a href="{{ route('etudiant.supports.showPdf', ['id' => $support->id_support]) }}" target="_blank" rel="noopener noreferrer">
      Ouvrir le document PDF
    </a>
  </p>

  <form action="{{ route('support.translate.process') }}" method="POST">
    @csrf
    <input type="hidden" name="id_support" value="{{ $support->id_support }}">

    <label for="text_to_translate" class="form-label">Texte à traduire :</label>
    <textarea id="text_to_translate" name="text_to_translate" rows="7" class="form-control" placeholder="Collez ici le texte à traduire..." required>{{ old('text_to_translate') }}</textarea>

    <label for="target_language" class="form-label mt-3">Choisir la langue de traduction :</label>
    <select id="target_language" name="target_language" class="form-select" required>
      <option value="" disabled {{ old('target_language') ? '' : 'selected' }}>-- Sélectionnez une langue --</option>
      <option value="en" {{ old('target_language') == 'en' ? 'selected' : '' }}>Français vers Anglais</option>
      <option value="ar" {{ old('target_language') == 'ar' ? 'selected' : '' }}>Français vers Arabe</option>
    </select>

    <button type="submit" class="btn btn-primary mt-3">Traduire</button>
  </form>

  @isset($translated)
    <div class="mt-4">
      <label for="translated_text" class="form-label"><strong>Traduction :</strong></label>
      <textarea id="translated_text" rows="7" class="form-control" readonly>{{ $translated }}</textarea>
    </div>
  @endisset

  @if($errors->any())
    <div class="alert alert-danger mt-3">
      {{ $errors->first() }}
    </div>
  @endif
</div>
@endsection


