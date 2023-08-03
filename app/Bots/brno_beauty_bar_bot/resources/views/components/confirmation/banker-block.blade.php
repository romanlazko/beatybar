<div class="block w-full">
    <span class="">
        - Banker: {{ $confirmation->banker_id }}
    </span>
    @can('update_confirmation_banker')
        <span class="edit hover:text-blue-500 text-sm text-gray-500">
            <i class="fa-solid fa-pen-to-square"></i>
            <x-badge color="brown" trigger="{{ $confirmation->banker_commission }}">
                <span class="font-bold">{{ $confirmation->banker_commission }}</span>
            </x-badge>
        </span>
        @if ($confirmation->status !== 'new')
            <form method="POST" action="{{ route('confirmation.update', $confirmation) }}" class="bg-gray-200 p-3 my-2 rounded-md space-y-2 form hidden">
                @csrf
                @method('patch')
                <input type="hidden" name="event" value="update_confirmation_banker">
                <div>
                    <x-form.select name="banker_id" class="mt-1 block w-full" :value="old('banker_id', $confirmation->banker_id)" required autocomplete="banker_id">
                        <option value="0" selected disabled>Banker:</option>
                        @foreach (App\Models\User::all() as $user)
                            <option value="{{ $user->chat_id }}" @selected($confirmation->banker_id === $user->chat_id)>{{ $user->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-form.input name="banker_commission" type="text" class="mt-1 block w-full" :value="old('banker_commission', $confirmation->banker_commission)" autocomplete="banker_commission" placeholder="Comission:" list="banker_commission_list"/>
                        
                    <datalist id="banker_commission_list">
                        <option value="150">
                        @can('view_confirmation_prague')
                            <option value="500">
                        @endcan
                    </datalist>
                </div>
                <div class="flex items-center gap-4">
                    <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
                    <x-a-buttons.secondary class="edit">{{ __('╳ Close') }}</x-a-buttons.primary>
                </div>
            </form>
        @endif
    @endcan
</div>