@if (auth()->user()->isAdmin())
    <x-nav-link :href="route('VBBeautyBot.client.index')" :active="request()->routeIs('VBBeautyBot.client.*')">
        {{ __('Clients') }}
    </x-nav-link>
@endif

<x-nav-link :href="route('VBBeautyBot.schedule.index')" :active="request()->routeIs('VBBeautyBot.schedule.*')">
    {{ __('Schedule') }}
</x-nav-link>
<x-nav-link :href="route('VBBeautyBot.appointment.index')" :active="request()->routeIs('VBBeautyBot.appointment.*')">
    {{ __('Appointments') }}
</x-nav-link>