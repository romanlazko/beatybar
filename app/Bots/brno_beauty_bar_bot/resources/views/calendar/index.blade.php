<x-telegram::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Calendar') }}
            </h2>
        </div>
    </x-slot>
    <x-slot name="main">
        <div>
            <x-telegram::white-block class="p-8 space-y-4">

            </x-telegram::white-block>
        </div>
        <div class="flex space-x-3 w-full">
            <div class="w-2/6">
                <x-telegram::white-block class="p-8 space-y-4">
                    <div class="">
                        <h1 class="text-2xl font-bold">Calendar plan</h1>
                    </div>
                    <div class="border border-indigo-600 rounded-lg p-5">
                        <div class="flex items-center justify-between"> 
                            <h1 class="text-2xl">{{request()->date}}</h1>
                            <button id="addTask" class="leading-10 w-10 rounded-full hover:bg-indigo-300 bg-indigo-100 text-2xl">+</button>
                        </div>
                    </div>
                </x-telegram::white-block>
            </div>
            <div class="w-4/6">
                <x-telegram::white-block>
                    <form class="mx-auto p-4">
                        <div class="calendar-widget">
                            <div class="flex items-center justify-between mb-4">
                                <label for="subMonth" class="leading-10 w-10 rounded-full hover:bg-indigo-300 bg-indigo-100 text-center">
                                    <input id="subMonth" type="submit" class="hidden" value="{{ Carbon\Carbon::parse(request()->month)->subMonth()->format('Y-m-d') ?? now()->subMonth()->format('Y-m-d') }}" onclick="$('#month').val($(this).val());"/>
                                    &lt;
                                </label>
                                <div id="currentDate" class="font-bold text-lg">{{ Carbon\Carbon::parse(request()->month)->format('m.Y') }}</div>
                                <input id="month" name="month" type="text" class="hidden" value="{{ request()->month }}"/>
                                <label for="addMonth" class="leading-10 w-10 rounded-full hover:bg-indigo-300 bg-indigo-100 text-center">
                                    <input id="addMonth" type="submit" class="hidden" value="{{ Carbon\Carbon::parse(request()->month)->addMonth()->format('Y-m-d') ?? now()->addMonth()->format('Y-m-d') }}" onclick="$('#month').val($(this).val());"/>
                                    &gt;
                                </label>
                            </div>
                            <div class="grid grid-cols-7 text-center mt-2">
                                @forelse ($calendar->get('days_of_week') as $day)
                                    <p class="items-center justify-center hover:bg-indigo-100 text-center p-1 border">
                                        {{ $day[0] }}
                                    </p>
                                @empty
                                    
                                @endforelse
                            </div>
                            @forelse ($calendar->get('weeks') as $week)
                                <div class="grid grid-cols-7 text-center">
                                    @forelse ($week as $day)
                                        <label for="{{ $day[0] }}" class="items-center justify-center hover:bg-indigo-100 text-center p-3 border {{ now()->format('Y-m-d') == $day[2] ? 'bg-indigo-300' : '' }} {{ (request()->date == $day[2] AND request()->date) ? 'bg-indigo-100' : '' }}">
                                            <input id="{{ $day[0] }}" name="date" type="checkbox" class="hidden" value="{{ $day[2] }}" onchange="$(this).closest('form').submit();"/>
                                            {{ $day[0] }}
                                        </label>
                                    @empty
                                        
                                    @endforelse
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </form>
                    
                </x-telegram::white-block>
            </div>
        </div>
    </x-slot>
    @section('script')
        
    @endsection
</x-telegram::layout>