<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->getId(),
            'name'=> $this->getName(),
            'email'=> $this->getEmail(),
            'phone'=> $this->getPhone(),
            'profile_image' => $this->getProfileImage(),
            'location' => $this->getLocation()
        ];
    }
}
