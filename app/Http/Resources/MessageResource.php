<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender_id' => $this->getSenderId(),
            'recipient_id' => $this->getRecipientId(),
            'text' => $this->getText(),
            'read_at' => $this->getReadAt()
        ];
    }
}
