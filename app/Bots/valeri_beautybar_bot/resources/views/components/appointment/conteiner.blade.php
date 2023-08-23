<x-telegram::white-block class="h-min space-y-4 confirmation p-4 sm:p-8">
    <x-valeri_beautybar_bot::appointment.header :appointment="$appointment"/>

    <x-valeri_beautybar_bot::appointment.date-block :appointment="$appointment" :index="$index"/>

    <x-valeri_beautybar_bot::appointment.price-block :appointment="$appointment" :index="$index"/>

    <x-valeri_beautybar_bot::appointment.master-block :appointment="$appointment" :index="$index"/>

    <x-valeri_beautybar_bot::appointment.change-status-block :appointment="$appointment" :index="$index"/>
</x-telegram::white-block>