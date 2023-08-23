
    @if ($appointment->status === 'new')
        <div class="block">
            <div class="flex justify-center" onclick="$(this).closest('.block').find('.form').toggle()">
                <span class="text-sm text-gray-500 hover:underline text-center">
                    <span>Show more</span>
                    <br>
                    <span class="text-xl">↓</span> 
                </span>
            </div>
            
            <div>
                <form method="POST" action="{{ route('VBBeautyBot.appointment.update', $appointment) }}" class="bg-gray-200 p-3 my-2 rounded-md space-y-2 form hidden">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="event" value="update_confirmation_status">
                    <input type="hidden" name="banker_id" value="{{ auth()->user()->chat_id }}">
                    <div>
                        <x-telegram::form.select name="status" class="mt-1 block w-full status" required>
                            <option value="done">Done</option>
                            <option value="no_done">Canceled</option>
                        </x-telegram::form.select>
                    </div>
                    <div class="price">
                        <x-telegram::form.input name="price" type="text" class="mt-1 block w-full" required="true" :value="old('price', $appointment->price)" placeholder="Price:" list="price_list"/>
                        
                        <datalist id="price_list">
                            <option value="1700">1700</option>
                            <option value="1500">1500</option>
                            <option value="1400">1400</option>
                            <option value="1200">1200</option>
                            <option value="1000">1000</option>
                            <option value="800">800</option>
                            <option value="500">500</option>
                            <option value="0">Free</option>
                        </datalist>
                    </div>
                    <div class="flex items-center gap-4">
                        <x-telegram::buttons.primary>
                            {{ __('Save') }}
                        </x-telegram::buttons.primary>

                        <x-telegram::a-buttons.secondary onclick="$(this).closest('.block').find('.cost_form').toggle()">
                            {{ __('╳ Close') }}
                        </x-telegram::a-buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    @endif