
<x-telegram::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Your Page') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="main">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <x-modal name="editEventModal">
            <div class="relative">
                <form method="post" id="editEventModalForm" class="p-6">
                    @csrf
                    @method('patch')
    
                    <div class="mt-6 w-full">
                        <x-input-label for="editEventTerm" value="{{ __('Term') }}"/>
                        <x-text-input id="editEventTerm" name="term" type="time" class="w-full"/>
                    </div>
    
                    <div class="mt-6 flex justify-end w-full">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Close') }}
                        </x-secondary-button>
            
                        <x-primary-button class="ml-3">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
    
                <form method="POST" id="deleteEventModalForm" class="p-6 absolute bottom-0">
                    @csrf
                    @method('delete')
                    <x-danger-button onclick="return confirm('Вы уверены, что хотите удалить элемент?')">
                        <i class="fa-solid fa-trash mr-1 text-sm"></i>
                        <p class="hidden sm:block">
                            {{ __('Delete') }}
                        </p>
                    </x-danger-button>
                </form>
            </div>
            
        </x-modal>
        <button id="editEventModalButton" class="hidden"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'editEventModal')"
        ></button>
        <div class="w-full space-y-3 sm:flex sm:space-x-3 sm:space-y-0">
            <div class="w-full sm:w-1/3 space-y-3">
                @if (auth()->user()->isAdmin())
                    <x-telegram::white-block>
                        <form action="{{ route('brno_beauty_bar_bot.schedule.index') }}" id="userForm">
                            <div class="">
                                <x-input-label for="user" value="{{ __('User') }}"/>
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

                @if (request('user', auth()->user()->id))
                    <x-telegram::white-block>
                        <form method="post" action="{{ route('brno_beauty_bar_bot.schedule.store') }}">
                            @csrf

                            <input name="user" type="hidden" value="{{ request('user', auth()->user()->id) }}"/>
                
                            <div class=" w-full flex space-x-2">
                                <div class="w-full" >
                                    <x-input-label for="start_date" value="{{ __('From:') }}"/>
                                    <x-text-input id="start_date" name="start_date" type="date" class="w-full" value="{{ old('start_date', now()->format('Y-m-d')) }}"/>
                                </div>
                                <div class="w-full" >
                                    <x-input-label for="end_date" value="{{ __('To:') }}"/>
                                    <x-text-input id="end_date" name="end_date" type="date" class="w-full" value="{{ old('end_date', now()->format('Y-m-d')) }}"/>
                                </div>
                                
                            </div>
            
                            <div class="mt-6">
                                <x-input-label for="term" value="{{ __('Term:') }}"/>
                                <x-text-input id="term" name="term" type="time" class="w-full" value="{{ request('term') }}"/>
                                <x-input-error :messages="$errors->get('term')" class="mt-2" />
                            </div>
                
                            <div class="mt-6">
                                <x-telegram::buttons.primary>
                                    {{ __('Add Schedule') }}
                                </x-telegram::buttons.primary>
                            </div>
                        </form>
                    </x-telegram::white-block>
                @endif
            </div>
            <div class="w-full sm:w-2/3">
                <x-telegram::white-block>
                    <div id='calendar' class="w-full text-[10px] sm:text-base"></div>
                </x-telegram::white-block>
            </div>
        </div>
        
    </x-slot>
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var events = @json($events);
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    height: 'auto',
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next'
                    },
                    titleFormat: { year: 'numeric', month: 'short' }, 
                    dayHeaderFormat: { weekday: 'short', omitCommas: true }, 
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    eventDisplay: 'block',
                    events: events,
                    defaultRangeSeparator: '-',
                    eventClick: function (eventClickInfo) {
                        document.getElementById('editEventModalButton').click();

                        editEventModalForm.setAttribute('action', "{{ route('brno_beauty_bar_bot.schedule.update', '') }}/"+eventClickInfo.event.id);
                        editEventTerm.setAttribute('value', eventClickInfo.event.startStr.split('T')[1].split('+')[0]);

                        deleteEventModalForm.setAttribute('action', "{{ route('brno_beauty_bar_bot.schedule.destroy', '') }}/"+eventClickInfo.event.id);
                    },
                    firstDay: 1,
                    dayMaxEventRows: true, 
                    selectable: true,
                    select: function (info) {
                        var start_date = document.getElementById('start_date');
                        var end_date = document.getElementById('end_date');

                        start_date.setAttribute('value', info.startStr);

                        var inputDate = new Date(info.endStr);

                        inputDate.setDate(inputDate.getDate() - 1);

                        var year = inputDate.getFullYear();
                        var month = String(inputDate.getMonth() + 1).padStart(2, '0');
                        var day = String(inputDate.getDate()).padStart(2, '0');

                        var formattedDate = year + '-' + month + '-' + day;

                        end_date.setAttribute('value', formattedDate);
                    },
                });
                calendar.render();
            });
        </script>
    @endsection
</x-telegram::layout>