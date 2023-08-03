<x-telegram::white-block class="h-min space-y-4 confirmation p-4 sm:p-8">
    <x-brno_beauty_bar_bot::appointment.header :appointment="$appointment"/>

    <x-brno_beauty_bar_bot::appointment.date-block :appointment="$appointment" :index="$index"/>

    <x-brno_beauty_bar_bot::appointment.price-block :appointment="$appointment" :index="$index"/>

    <x-brno_beauty_bar_bot::appointment.master-block :appointment="$appointment" :index="$index"/>

    <x-brno_beauty_bar_bot::appointment.change-status-block :appointment="$appointment" :index="$index"/>
</x-telegram::white-block>