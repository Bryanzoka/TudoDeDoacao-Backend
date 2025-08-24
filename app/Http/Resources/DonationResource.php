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
            'name' => $this->name,
            'description' => $this->description,
            'brief_description' => $this->brief_description,
            'category' => $this->category,
            'image' => $this->image,
            'location' => $this->location,
            'status' => $this->status,
            'created_at' => $this->created_at,  
            'updated_at' => $this->updated_at, 
        ];
    }
}
