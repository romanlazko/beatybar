@if (auth()->user()->isAdmin())
    <x-responsive-nav-link :href="route('valeri_beautybar_bot.client.index')" :active="request()->routeIs('valeri_beautybar_bot.client.*')">
        {{ __('Clients') }}
    </x-responsive-nav-link>
@endif
<x-responsive-nav-link :href="route('valeri_beautybar_bot.schedule.index')" :active="request()->routeIs('valeri_beautybar_bot.schedule.*')">
    {{ __('Schedule') }}
</x-responsive-nav-link>
<x-responsive-nav-link :href="route('valeri_beautybar_bot.appointment.index')" :active="request()->routeIs('valeri_beautybar_bot.appointment.*')">
    {{ __('Appointments') }}
</x-responsive-nav-link>
