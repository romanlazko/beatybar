<?php 
namespace App\Bots\valeri_beautybar_bot\Providers;

use App\Bots\valeri_beautybar_bot\Events\CancelAppointmentEvent;
use App\Bots\valeri_beautybar_bot\Events\NewAppointment;
use App\Bots\valeri_beautybar_bot\Events\TomorrowAppointment;
use App\Bots\valeri_beautybar_bot\Events\UpdateAppointment;
use App\Bots\valeri_beautybar_bot\Listeners\SendToAdminCancelAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToAdminNewAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToAdminTomorrowAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToAdminUpdateAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToUserCancelAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToUserNewAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToUserTomorrowAppointmentNotification;
use App\Bots\valeri_beautybar_bot\Listeners\SendToUserUpdateAppointmentNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        NewAppointment::class => [
            SendToUserNewAppointmentNotification::class,
            SendToAdminNewAppointmentNotification::class,
        ],
        UpdateAppointment::class => [
            SendToUserUpdateAppointmentNotification::class,
            SendToAdminUpdateAppointmentNotification::class,
        ],
        CancelAppointmentEvent::class => [
            SendToAdminCancelAppointmentNotification::class,
            SendToUserCancelAppointmentNotification::class,
        ],
        TomorrowAppointment::class => [
            SendToAdminTomorrowAppointmentNotification::class,
            SendToUserTomorrowAppointmentNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}