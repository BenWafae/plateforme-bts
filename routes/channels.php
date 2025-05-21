<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// // route prof utilisation de guard web par defaut;

// le but de cette partie c d autoriser lacces au canal prive uniquement pour lutilisateur aynt id_user; et ayant le role professeur
 Broadcast::channel('professeur.{id_user}', function ($user, $id_user) {
      return (int) $user->id_user === (int) $id_user && $user->role === 'professeur'; });


