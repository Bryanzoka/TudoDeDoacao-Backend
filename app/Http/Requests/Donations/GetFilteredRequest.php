<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;

class GetFilteredRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'max:150'],
            'category' => ['nullable', 'max:50'],
            'location' => ['nullable', 'max:150'],
            'status' => ['nullable', 'max:20'],
            'limit' => ['nullable', 'min:1', 'max:70'],
            'offset' => ['nullable', 'min:0']
        ];
    }
}
