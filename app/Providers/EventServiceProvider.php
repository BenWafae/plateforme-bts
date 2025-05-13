<?php
namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// Importation des événements et listeners
use App\Events\SupportConsulted;
use App\Events\SupportDownloaded;
use App\Listeners\SupportConsultedListener;
use App\Listeners\SupportDownloadedListener;

use App\Events\ReponseAjoutee;
use App\Events\QuestionSupprimee;
use App\Listeners\NotifierReponseAjoutee;
use App\Listeners\NotifierQuestionSupprimee;

use App\Events\ReponseCreated;  // Ajouter l'événement
use App\Listeners\UpdateNotificationWithReponse;  // Ajouter le listener

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SupportConsulted::class => [
            SupportConsultedListener::class,
        ],
        SupportDownloaded::class => [
            SupportDownloadedListener::class,
        ],
        QuestionSupprimee::class => [
            NotifierQuestionSupprimee::class,
        ],
        ReponseAjoutee::class => [
            NotifierReponseAjoutee::class,
        ],
        // Ajouter l'événement et le listener pour la réponse
        ReponseAjoutee::class => [
            UpdateNotificationWithReponse::class,
        ],
       
        // Listener et event : notification professeur
        \App\Events\QuestionCreee::class => [
            \App\Listeners\NotifierProfesseur::class,
        ],

        // Ajouter l'événement et le listener pour la réponse
        ReponseCreated::class => [
            UpdateNotificationWithReponse::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
