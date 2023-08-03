<x-telegram::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Client create') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="main">
        <x-telegram::white-block>
            <form method="post" action="{{ route('brno_beauty_bar_bot.client.store') }}" class="space-y-6">
                @csrf
                @method('POST')

                <div class="">
                    <x-input-label for="telegram_chat_id" value="{{ __('User') }}"/>
                    <x-telegram::form.select name="telegram_chat_id" class="w-full">
                        <option value="">Without chat</option>
                        @forelse ($telegram_chats as $telegram_chat)
                            <option value="{{ $telegram_chat->id }}">{{ $telegram_chat->first_name }} {{ $telegram_chat->last_name }} ({{ $telegram_chat->username }})</option>
                        @empty
                            
                        @endforelse
                    </x-telegram::form.select>
                    <x-input-error :messages="$errors->get('user')" class="mt-2" />
                </div>
            
                <div>
                    <x-telegram::form.label for="first_name" :value="__('First name:')" />
                    <x-telegram::form.input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autocomplete="first_name" />
                    <x-telegram::form.error class="mt-2" :messages="$errors->get('first_name')" />
                </div>
            
                <div>
                    <x-telegram::form.label for="last_name" :value="__('Last name:')" />
                    <x-telegram::form.input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" autocomplete="last_name" />
                    <x-telegram::form.error class="mt-2" :messages="$errors->get('last_name')" />
                </div>
            
                <div>
                    <x-telegram::form.label for="phone" :value="__('Phone:')" />
                    <x-telegram::form.input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" autocomplete="phone" />
                    <x-telegram::form.error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            
                <div class="flex items-center gap-4">
                    <x-telegram::buttons.primary>
                        {{ __('Create') }}
                    </x-telegram::buttons.primary>
                </div>
            </form>
        </x-telegram::white-block>
    </x-slot>
</x-telegram::layout>
