<div class="block w-full">
    <button onclick="$(this).closest('.block').find('.form').toggle('fast')">
        - Price: 
        <x-telegram::badge trigger="{{ $appointment->price }}">
            <span class="font-bold">{{ $appointment->price }}</span>
        </x-telegram::badge>
        <span class="hover:text-blue-500 text-sm text-gray-500"><i class="fa-solid fa-pen-to-square"></i></span>
    </button>
    
    @if ($appointment->status !== 'new' OR $appointment->price)
        <form method="POST" action="{{ route('brno_beauty_bar_bot.appointment.update', $appointment) }}" class="bg-gray-200 p-3 my-2 rounded-md space-y-2 form hidden">
            @csrf
            @method('patch')
            <div>
                <x-telegram::form.input name="price" type="text" class="mt-1 block w-full" :value="old('price', $appointment->price)" required/>
            </div>
            <div class="flex items-center gap-4">
                <x-telegram::buttons.primary>
                    {{ __('Save') }}
                </x-buttons.primary>

                <x-telegram::a-buttons.secondary onclick="$(this).closest('.block').find('form').toggle()">
                    {{ __('╳ Close') }}
                </x-telegram::a-buttons.primary>
            </div>
        </form>
    @endif
</div>