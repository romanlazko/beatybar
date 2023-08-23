<?php 
namespace App\Bots\VBBeautyBot\Providers;

use App\Bots\VBBeautyBot\Events\CancelAppointmentEvent;
use App\Bots\VBBeautyBot\Events\NewAppointment;
use App\Bots\VBBeautyBot\Events\TomorrowAppointment;
use App\Bots\VBBeautyBot\Events\UpdateAppointment;
use App\Bots\VBBeautyBot\Listeners\SendToAdminCancelAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToAdminNewAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToAdminTomorrowAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToAdminUpdateAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToUserCancelAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToUserNewAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToUserTomorrowAppointmentNotification;
use App\Bots\VBBeautyBot\Listeners\SendToUserUpdateAppointmentNotification;
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