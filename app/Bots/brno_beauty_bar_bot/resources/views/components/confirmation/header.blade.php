<div class="space-y-2">
    <div class="flex w-full items-start">
        <div class="flex-col w-2/3">
            <div class="flex items-center space-x-2">
                @if ($confirmation->bank === 'air') 
                    <i>
                        <img class="w-5 rounded-full" src="/img/icons/2023-05-31 17.26.15.jpg" alt="">
                    </i>
                @elseif($confirmation->bank === 'uni') 
                    <i>
                        <img class="w-5 rounded-full" src="/img/icons/unnamed.png" alt="">
                    </i>
                @elseif($confirmation->bank === 'cs')
                    <i>
                        <img class="w-5 rounded-full" src="/img/icons/3djiJU7L_400x400.jpg" alt="">
                    </i>
                @endif

                @if($confirmation->status === 'done') 
                    <span class="text-green-600 text-lg font-bold">
                        Confirm id: {{ $confirmation->id }}
                    </span>
                @elseif($confirmation->status === 'new') 
                    <span class="text-blue-600 text-lg font-bold">
                        Confirm id: {{ $confirmation->id }}
                    </span>
                @elseif($confirmation->status === 'canceled' OR $confirmation->status === 'no_done')
                    <span class="text-red-600 text-lg font-bold">
                        Confirm id: {{ $confirmation->id }}
                    </span>
                @endif
            </div>
            <div class="w-full text-gray-400 text-xs">
                <div onclick="alert('Created at: {{ $confirmation->created_at->format('d.m.Y (H:i:s)') }}')">
                    Created: {{ $confirmation->created_at->diffForHumans() }}
                </div>
                <div onclick="alert('Updated at: {{ $confirmation->updated_at->format('d.m.Y (H:i:s)') }}')">
                    Updated: {{ $confirmation->updated_at->diffForHumans() }}
                </div>
            </div>
            
        </div>
        <div class="flex-col w-1/3">
            <div class="justify-end sm:flex sm:space-x-1 sm:space-y-0 space-y-1">
                <x-a-buttons.primary href="{{ route('contract', $confirmation) }}" class="edit-button text-xl w-min float-right sm:float-none" >
                    {{ __("Contract") }}
                </x-a-buttons.primary>
            </div>
        </div>
    </div>
    <div class="w-full">
        <a href="{{ route('profile.edit', $confirmation->profile) }}" class="font-bold text-lg hover:underline">{{ $confirmation->profile?->first_name }} {{ $confirmation->profile?->last_name }}</a>
        <x-badge color="blue">
            <a href="{{ route('get-contact', $confirmation->chat) }}" class="font-bold text-blue-700">
                {{ __('Contact') }}
            </a>
        </x-badge>
    </div>
</div>