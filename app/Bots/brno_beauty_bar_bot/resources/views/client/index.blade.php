<x-telegram::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Your Page') }}
            </h2>
            <x-telegram::a-buttons.secondary href="{{ route('brno_beauty_bar_bot.client.create') }}" >
                {{ __("+ Add client") }}
            </x-telegram::a-buttons.secondary>
        </div>
    </x-slot>
    <x-slot name="main">
        <x-telegram::white-block class="p-0">
            <x-telegram::search :action="route('chat.index')"/>
        </x-telegram::white-block>
        <x-telegram::white-block class="p-0">
            <x-telegram::table.table class="whitespace-nowrap">
                <x-telegram::table.thead class="text-left py-2 ">
                    <tr>
                        <x-telegram::table.th>id</x-telegram::table.th>
                        <x-telegram::table.th>Chat</x-telegram::table.th>
                        <x-telegram::table.th>Client</x-telegram::table.th>
                        <x-telegram::table.th>Phone</x-telegram::table.th>
                        <x-telegram::table.th>Referal id</x-telegram::table.th>

                        <x-telegram::table.th>Created<br>Updated</x-telegram::table.th>
                    </tr>
                </x-telegram::table.thead>
                <x-telegram::table.tbody>
                    @forelse ($clients as $index => $client)
                        <tr class="@if($index % 2 === 0) bg-gray-100 @endif text-sm">
                            <x-telegram::table.td>
                                {{ $client->id }}
                            </x-telegram::table.td>

                            
                            <x-telegram::table.td class="whitespace-nowrap">
                                @if ($client->telegram_chat)
                                    <x-telegram::chat-block :id="$client->telegram_chat->id"/>
                                @endif
                               
                            </x-telegram::table.td>

                            <x-telegram::table.td>
                                <a class="hover:underline" href="{{ route('brno_beauty_bar_bot.client.edit', $client) }}">
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </a>
                            </x-telegram::table.td>

                            <x-telegram::table.td>
                                {{ $client->phone }}
                            </x-telegram::table.td>

                            <x-telegram::table.td>
                                {{ $client->telegram_chat?->referal_id }}
                            </x-telegram::table.td>

                            <x-telegram::table.td class="text-xs">
                                <p title="{{ $client->created_at->format('d.m.Y (H:i)') }}">
                                    {{ $client->created_at->diffForHumans() }}
                                </p>
                                <p title="{{ $client->updated_at->format('d.m.Y (H:i)') }}">
                                    {{ $client->updated_at->diffForHumans() }}
                                </p>
                            </x-telegram::table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-telegram::table.td></x-telegram::table.td>
                            <x-telegram::table.td>Nothing found</x-telegram::table.td>
                        </tr>
                    @endforelse
                </x-telegram::table.tbody>
            </x-telegram::table.table>
            
        </x-telegram::white-block>
        <div>
            {{$clients->links()}}
        </div>
    </x-slot>
</x-telegram::layout>