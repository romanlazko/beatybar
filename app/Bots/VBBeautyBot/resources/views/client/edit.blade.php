<x-telegram::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Client') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="w-full space-y-3 sm:flex sm:space-x-3 sm:space-y-0">
            <div class="w-full">
                <x-telegram::white-block>
                    <form method="post" action="{{ route('VBBeautyBot.client.update', $client) }}" >
                        @csrf
                        @method('patch')

                        <div class="space-y-6">
                            <div class="">
                                <x-input-label for="telegram_chat_id" value="{{ __('Chat:') }}"/>
                                <x-telegram::form.select name="telegram_chat_id" class="w-full">
                                    <option value="">Without chat</option>
                                    @if ($client->telegram_chat)
                                        <option selected value="{{ $client->telegram_chat_id }}">{{ $client->telegram_chat->first_name }} {{ $client->telegram_chat->last_name }} ({{ $client->telegram_chat->username }})</option>
                                    @endif
                                    
                                    @forelse ($telegram_chats as $telegram_chat)
                                        <option value="{{ $telegram_chat->id }}">{{ $telegram_chat->first_name }} {{ $telegram_chat->last_name }} ({{ $telegram_chat->username }})</option>
                                    @empty
                                        
                                    @endforelse
                                </x-telegram::form.select>
                                <x-input-error :messages="$errors->get('user')" class="mt-2" />
                            </div>
                            
                        
                            <div>
                                <x-telegram::form.label for="first_name" :value="__('First name:')" />
                                <x-telegram::form.input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $client->first_name)" required autocomplete="first_name" />
                                <x-telegram::form.error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>
                        
                            <div>
                                <x-telegram::form.label for="last_name" :value="__('Last name:')" />
                                <x-telegram::form.input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $client->last_name)" required autocomplete="last_name" />
                                <x-telegram::form.error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>
                        
                            <div>
                                <x-telegram::form.label for="phone" :value="__('Phone:')" />
                                <x-telegram::form.input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $client->phone)" required autocomplete="phone" />
                                <x-telegram::form.error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <x-telegram::form.label for="referal_id" :value="__('Referal id:')" />
                                <x-telegram::form.input id="referal_id" name="referal_id" type="text" class="mt-1 block w-full" :value="old('referal_id', $client->telegram_chat?->referal_id)" autocomplete="referal_id" />
                                <x-telegram::form.error class="mt-2" :messages="$errors->get('referal_id')" />
                            </div>
                        
                            <div class="grid grid-cols-1 w-full">
                                <span class="w-full text-gray-400 text-xs" title="{{ $client->created_at->format('d.m.Y - H:i:s') }}">Created at: {{ $client->created_at->diffForHumans() }}</span>
                                <span class="w-full text-gray-400 text-xs" title="{{ $client->updated_at->format('d.m.Y - H:i:s') }}">Updated at: {{ $client->updated_at->diffForHumans() }}</span>
                            </div>
                        
                            <div class="flex items-center gap-4">
                                <x-telegram::buttons.primary>
                                    {{ __('Save') }}
                                </x-telegram::buttons.primary>
                            </div>
                        </div>
                    </form>
                </x-telegram::white-block>
            </div>
            <div class="w-full space-y-3">
                @if (auth()->user()->isAdmin())
                    <x-telegram::white-block>
                        <form action="{{ route('VBBeautyBot.client.edit', $client ) }}" id="userForm">
                            <div class="">
                                <x-input-label for="user" value="{{ __('User:') }}"/>
                                <x-telegram::form.select name="user" class="w-full" onchange="$('#userForm').submit();">
                                    <option value="">Choose</option>
                                    @forelse (App\Models\User::all() as $user)
                                        <option @selected(request('user', auth()->user()->id) == $user->id) value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                        
                                    @endforelse
                                </x-telegram::form.select>
                                <x-input-error :messages="$errors->get('user')" class="mt-2" />
                            </div>
                        </form>
                    </x-telegram::white-block>
                @endif

                <x-telegram::white-block>
                    <form method="post" action="{{ route('VBBeautyBot.appointment.store') }}">
                        @csrf
                        @method('post')

                        <input type="hidden" name="client" value="{{ $client->id }}">
                    
                        <div>
                            <x-telegram::form.select name="schedule" class="w-full">
                                @forelse ($schedule as $date_schedules)
                                    @foreach ($date_schedules->sortBy('term') as $date => $schedule)
                                        <option value="{{ $schedule->id }}">{{ $schedule->date->format('d.m.Y (D)') }}: {{ $schedule->term }}</option>
                                    @endforeach
                                @empty
                
                                @endforelse
                            </x-telegram::form.select>
                        </div>
                            
                    
                        <div class="flex items-center gap-4 mt-6">
                            <x-telegram::buttons.primary>
                                {{ __('Save') }}
                            </x-telegram::buttons.primary>
                        </div>
                    </form>
                </x-telegram::white-block>

                <div class="w-full space-y-3">
                    @forelse ($appointments as $index => $appointment)
                        <x-VBBeautyBot::appointment.conteiner :appointment="$appointment" :index="$index"/>
                    @empty
                        
                    @endforelse
                    
                </div>
            </div>
        </div>
        
    </x-slot>
</x-telegram::layout>
