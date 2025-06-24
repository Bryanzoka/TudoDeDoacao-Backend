<?php

namespace App\Http\Requests\DonationRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\DonationStatus;

class DonationRequest extends FormRequest
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
            'donation_name' => ['required', 'string', 'min:2', 'max:70'],
            'donation_description' => ['nullable', 'string', 'max:255'],
            'donation_briefDescription' => ['nullable', 'string', 'max:70'],
            'donation_category' => ['nullable', 'max:50'],
            'donation_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
            'donation_location' => ['required', 'string', 'max:100'],
            'donation_status' => ['nullable', new Enum(DonationStatus::class)]
        ];
    }
}
