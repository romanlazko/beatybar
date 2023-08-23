@if (auth()->user()->isAdmin())
    <x-nav-link :href="route('valeri_beautybar_bot.client.index')" :active="request()->routeIs('valeri_beautybar_bot.client.*')">
        {{ __('Clients') }}
    </x-nav-link>
@endif

<x-nav-link :href="route('valeri_beautybar_bot.schedule.index')" :active="request()->routeIs('valeri_beautybar_bot.schedule.*')">
    {{ __('Schedule') }}
</x-nav-link>
<x-nav-link :href="route('valeri_beautybar_bot.appointment.index')" :active="request()->routeIs('valeri_beautybar_bot.appointment.*')">
    {{ __('Appointments') }}
</x-nav-link>