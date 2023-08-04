<?php

namespace App\Bots\brno_beauty_bar_bot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'client' => ['required', 'integer', Rule::exists('clients', 'id')],
            'schedule' => ['required', 'integer', Rule::exists('schedules', 'id')],
        ];
    }
}
