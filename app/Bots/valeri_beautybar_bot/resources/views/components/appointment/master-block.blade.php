<div class="block w-full">
    <button >
        - Master: 
        <x-telegram::badge>
            {{ $appointment->schedule?->user->name }}
        </x-telegram::badge>
    </button>
</div>