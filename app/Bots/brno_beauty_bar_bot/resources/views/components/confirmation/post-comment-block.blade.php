<div class="block grid grid-cols-1 w-full">
    <span>
        - Post comment:
        <span class="edit hover:text-blue-500 text-sm text-gray-500"><i class="fa-solid fa-pen-to-square"></i></span>
    </span>
    <x-badge trigger="{{ $confirmation->post_comment }}">
        <span class="text text-xs text-gray-600 font-bold">
            {{ $confirmation->post_comment }}
        </span>
    </x-badge>

    @can('update_confirmation_comment')
        @if ($confirmation->status !== 'new')
            <form method="POST" action="{{ route('confirmation.update', $confirmation) }}" class="bg-gray-200 p-3 my-2 rounded-md space-y-2 form hidden">
                @csrf
                @method('patch')
                <input type="hidden" name="event" value="update_confirmation_post_comment">
                <div>
                    <x-form.input name="post_comment" type="text" class="mt-1 block w-full" :value="old('post_comment', $confirmation->post_comment)" required autocomplete="post_comment" />
                </div>
                <div class="flex items-center gap-4">
                    <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
                    <x-a-buttons.secondary class="edit">{{ __('╳ Close') }}</x-a-buttons.primary>
                </div>
            </form>
        @endif
    @endcan
</div>