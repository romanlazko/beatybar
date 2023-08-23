<?php

namespace App\Bots\VBBeautyBot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'telegram_chat_id' => ['nullable', 'integer', 'unique:clients'],
            'first_name' => ['required', 'string', ],
            'last_name' => ['sometimes', 'nullable', 'string', ],
            'phone' => ['sometimes', 'nullable', 'string', ],
        ];
    }
}
