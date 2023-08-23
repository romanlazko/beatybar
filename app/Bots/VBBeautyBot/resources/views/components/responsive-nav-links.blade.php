@if (auth()->user()->isAdmin())
    <x-responsive-nav-link :href="route('VBBeautyBot.client.index')" :active="request()->routeIs('VBBeautyBot.client.*')">
        {{ __('Clients') }}
    </x-responsive-nav-link>
@endif
<x-responsive-nav-link :href="route('VBBeautyBot.schedule.index')" :active="request()->routeIs('VBBeautyBot.schedule.*')">
    {{ __('Schedule') }}
</x-responsive-nav-link>
<x-responsive-nav-link :href="route('VBBeautyBot.appointment.index')" :active="request()->routeIs('VBBeautyBot.appointment.*')">
    {{ __('Appointments') }}
</x-responsive-nav-link>
