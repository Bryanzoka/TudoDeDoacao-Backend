<?php

namespace App\Http\Requests\DonationRequests;
use Illuminate\Validation\Rules\Enum;
use App\Domain\ValueObjects\DonationStatus;

use Illuminate\Foundation\Http\FormRequest;

class DonationUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'min:2', 'max:70'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category' => ['sometimes', 'max:50'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
            'location' => ['sometimes', 'string', 'max:100'],
            'status' => ['sometimes', new Enum(DonationStatus::class)]
        ];
    }
}
