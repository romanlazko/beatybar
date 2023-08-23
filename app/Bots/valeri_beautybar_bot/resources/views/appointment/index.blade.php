<x-telegram::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointments') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="w-full space-y-3 sm:flex sm:space-y-0 sm:space-x-3"> 
            <div class="w-full ">
                <x-telegram::white-block>
                    <form id="form" method="get" action="{{ route('valeri_beautybar_bot.appointment.index') }}">
                        @if (auth()->user()->isAdmin())
                            <div class="mb-6">
                                <x-input-label for="user" value="{{ __('User') }}"/>
                                <x-telegram::form.select name="user" class="w-full" onchange="$('#form').submit();">
                                    @forelse (App\Models\User::all() as $user)
                                        <option @selected(request('user', auth()->user()->id) == $user->id) value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                        
                                    @endforelse
                                </x-telegram::form.select>
                                <x-input-error :messages="$errors->get('user')" class="mt-2" />
                            </div>
                        @endif
                        
            
                        <div class="w-full ">
                            <x-input-label for="date" value="{{ __('Date') }}"/>
                            <x-text-input id="date" name="date" type="date" class="w-full" value="{{ request('date') }}" onchange="$('#form').submit();"/>
                        </div>
            
                        <div class="mt-6">
                            <x-telegram::buttons.primary>
                                {{ __('Search') }}
                            </x-telegram::buttons.primary>
                        </div>
                    </form>
                </x-telegram::white-block>
            </div>
            <div class="w-full space-y-3">
                @forelse ($appointments as $index => $appointment)
                    <x-valeri_beautybar_bot::appointment.conteiner :appointment="$appointment" :index="$index"/>
                @empty
                    
                @endforelse
                
            </div>
        </div>
    </x-slot>
    @section('script')
        <script>
        </script>
    @endsection
</x-telegram::layout>