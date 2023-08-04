
<x-responsive-nav-link :href="route('brno_beauty_bar_bot.client.index')" :active="request()->routeIs('brno_beauty_bar_bot.client.*')">
    {{ __('Clients') }}
</x-responsive-nav-link>
<x-responsive-nav-link :href="route('brno_beauty_bar_bot.schedule.index')" :active="request()->routeIs('brno_beauty_bar_bot.schedule.*')">
    {{ __('Schedule') }}
</x-responsive-nav-link>
<x-responsive-nav-link :href="route('brno_beauty_bar_bot.appointment.index')" :active="request()->routeIs('brno_beauty_bar_bot.appointment.*')">
    {{ __('Appointments') }}
</x-responsive-nav-link>
