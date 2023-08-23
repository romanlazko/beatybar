<div class="block">
    <button onclick="$(this).closest('.block').find('.form').toggle('fast')">
        - Date: 
        <x-telegram::badge trigger="{{ isset($appointment->schedule->date) }}">
            {{ $appointment->schedule?->date->format('d.m.Y (D)')}}: {{ $appointment->schedule?->term }}
        </x-telegram::badge>
        <span class="hover:text-blue-500 text-sm text-gray-500"><i class="fa-solid fa-pen-to-square"></i></span>
    </button>

    @if ($appointment->status === 'new')
        <form method="POST" action="{{ route('VBBeautyBot.appointment.update', $appointment) }}" class="bg-gray-200 p-3 my-2 rounded-md space-y-2 form hidden">
            @csrf
            @method('patch')

            <div>
                <x-telegram::form.select name="schedule" class="w-full">
                    @forelse (
                        App\Bots\VBBeautyBot\Models\Schedule::with('appointment')
                            ->orderBy('date', 'asc')
                            ->where(function ($query) {
                                $user = auth()->user();
                                $query->where('user_id', $user->isAdmin() ? request('user', $user->id) : $user->id);
                            })
                            
                            ->where('date', '>=', now()->format('Y-m-d'))
                            ->get()
                            ->filter(function ($schedule) {
                                return $schedule->appointment == null;
                            })
                            ->groupBy(function ($schedule) {
                                return $schedule->date->format('Y-m-d');
                            })
                    as $date_schedules)
                        @foreach ($date_schedules->sortBy('term') as $date => $schedule)
                            <option value="{{ $schedule->id }}">{{ $schedule->date->format('d.m.Y (D)') }}: {{ $schedule->term }}</option>
                        @endforeach
                    @empty

                    @endforelse
                </x-telegram::form.select>
            </div>
            <div class="flex items-center gap-4">
                <x-telegram::buttons.primary>
                    {{ __('Save') }}
                </x-telegram::buttons.primary>
                <x-telegram::a-buttons.secondary onclick="$(this).closest('.block').find('.form').toggle('fast')">
                    {{ __('╳ Close') }}
                </x-telegram::a-buttons.primary>
            </div>
        </form>
    @endif
</div>