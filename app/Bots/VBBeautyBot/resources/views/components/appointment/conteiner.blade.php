<x-telegram::white-block class="h-min space-y-4 confirmation p-4 sm:p-8">
    <x-VBBeautyBot::appointment.header :appointment="$appointment"/>

    <x-VBBeautyBot::appointment.date-block :appointment="$appointment" :index="$index"/>

    <x-VBBeautyBot::appointment.price-block :appointment="$appointment" :index="$index"/>

    <x-VBBeautyBot::appointment.master-block :appointment="$appointment" :index="$index"/>

    <x-VBBeautyBot::appointment.change-status-block :appointment="$appointment" :index="$index"/>
</x-telegram::white-block>