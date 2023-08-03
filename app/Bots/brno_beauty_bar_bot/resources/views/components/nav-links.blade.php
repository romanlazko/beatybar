<x-nav-link :href="route('brno_beauty_bar_bot.client.index')" :active="request()->routeIs('brno_beauty_bar_bot.client.*')">
    {{ __('Clients') }}
</x-nav-link>
<x-nav-link :href="route('brno_beauty_bar_bot.schedule.index')" :active="request()->routeIs('brno_beauty_bar_bot.schedule.*')">
    {{ __('Schedule') }}
</x-nav-link>
<x-nav-link :href="route('brno_beauty_bar_bot.appointment.index')" :active="request()->routeIs('brno_beauty_bar_bot.appointment.*')">
    {{ __('Appointments') }}
</x-nav-link>