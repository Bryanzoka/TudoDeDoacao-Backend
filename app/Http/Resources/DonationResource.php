<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'donation_name' => $this->donation_name,
            'donation_description' => $this->donation_description,
            'donation_briefDescription' => $this->donation_briefDescription,
            'donation_category' => $this->donation_category,
            'donation_image' => $this->donation_image,
            'donation_location' => $this->donation_location,
            'donation_status' => $this->donation_status,
            'created_at' => $this->created_at,  
            'updated_at' => $this->updated_at, 
        ];
    }
}
