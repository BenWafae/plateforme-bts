<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
   public function boot()
     {
          View::composer('layouts.professeur', function ($view) {
     if (Auth::check() && Auth::user()->role === 'professeur') {
       $unreadCount = Notification::where('id_user', Auth::user()->id_user)
             ->where('lue', false)
             ->count();

         $view->with('unreadNotificationsCount', $unreadCount);
     }
  });
    
}
}