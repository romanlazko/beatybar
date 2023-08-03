<div class="space-y-2">
    <div class="flex w-full items-start">
        <div class="flex-col w-2/3">
            <div class="flex items-center space-x-2">
                @if($appointment->status === 'done') 
                    <span class="text-green-600 text-lg font-bold">
                        Appoint id: {{ $appointment->id }}
                    </span>
                @elseif($appointment->status === 'new') 
                    <span class="text-blue-600 text-lg font-bold">
                        Appoint id: {{ $appointment->id }}
                    </span>
                @elseif($appointment->status === 'canceled' OR $appointment->status === 'no_done')
                    <span class="text-red-600 text-lg font-bold">
                        Appoint id: {{ $appointment->id }}
                    </span>
                @endif
            </div>
            <div class="w-full text-gray-400 text-xs">
                <div onclick="alert('Created at: {{ $appointment->created_at?->format('d.m.Y (H:i:s)') }}')">
                    Created: {{ $appointment->created_at?->diffForHumans() }}
                </div>
                <div onclick="alert('Updated at: {{ $appointment->updated_at?->format('d.m.Y (H:i:s)') }}')">
                    Updated: {{ $appointment->updated_at?->diffForHumans() }}
                </div>
            </div>
            
        </div>
    </div>
    <div class="w-full">
        <a href="{{ route('brno_beauty_bar_bot.client.edit' , $appointment->client) }}" class="font-bold text-lg hover:underline">{{ $appointment->client?->first_name }} {{ $appointment->client?->last_name }}</a>
        @if ($appointment->client?->telegram_chat_id)
            <x-telegram::badge color="blue">
                <a href="{{ route('get-contact', ['chat' =>  $appointment->client?->telegram_chat_id]) }}" class="font-bold text-blue-700">
                    {{ __('Contact') }}
                </a>
            </x-telegram::badge>
        @endif
        
    </div>
</div>