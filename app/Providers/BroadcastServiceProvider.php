<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{


    public function boot()
    {
        // S'assurer que le middleware web est appliqué
        Broadcast::routes(['middleware' => ['web', 'auth']]);
        
        // Inclure les routes de channels.php
        require base_path('routes/channels.php');
    }
}