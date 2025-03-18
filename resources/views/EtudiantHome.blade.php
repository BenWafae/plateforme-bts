@extends('layouts.navbar')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <!-- Cercle centré avec icône et bienvenue -->
        <div class="user-circle text-center">
            <!-- Icône (par exemple, une icône d'accueil ou un smiley) -->
            <i class="fas fa-smile fa-3x"></i>
            <!-- Message de bienvenue -->
            <h2 class="mt-3">Bienvenue, {{ auth()->user()->prenom }} 👋</h2>
        </div>
    </div>
@endsection
