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
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'brief_description' => $this->getBriefDescription(),
            'category' => $this->getCategory(),
            'image' => $this->getImage(),
            'location' => $this->getLocation(),
            'status' => $this->getStatus()
        ];
    }
}
