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

use App\Events\NewQuestionPosted;
use App\Listeners\SendNewQuestionNotification;
use App\Events\ContentReported;
use App\Listeners\SendContentReportedNotification;

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
       
        QuestionSupprimee::class => [
            NotifierQuestionSupprimee::class,
        ],
        ReponseAjoutee::class => [
            NotifierReponseAjoutee::class,
        ],

       \App\Events\NewQuestionPosted::class => [
        \App\Listeners\NotifyAdminNewQuestion::class,
    ],
    \App\Events\ContentReported::class => [
        \App\Listeners\NotifyAdminReportedContent::class,
    ],
       
        // Listener et event : notification professeur
        \App\Events\QuestionCreee::class => [
            \App\Listeners\NotifierProfesseur::class,
        ],

        // Ajouter l'événement et le listener pour la réponse

        \App\Events\ReponseCreee::class => [
    \App\Listeners\NotifierProfReponse::class,
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
