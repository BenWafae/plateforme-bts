@extends('layouts.admin')

@section('title', 'Modifier la Filière')
@section('content')
<form action="{{ route('user.update', $user->id_user) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
@endsection
