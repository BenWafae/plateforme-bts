@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $support->titre }}</h1>
        <p>{{ $support->description }}</p>

        <div class="pdf-container">
            <iframe src="{{ asset('storage/' . $support->lien_url) }}" width="100%" height="600px"></iframe>
        </div>

        <a href="{{ route('supports.index') }}" class="btn btn-primary">Retour à la liste</a>
    </div>
@endsection
