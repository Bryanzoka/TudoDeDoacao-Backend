<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;

class DonationStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:70'],
            'user_id' => ['required'],
            'description' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
            'location' => ['required', 'string', 'max:100'],
        ];
    }
}