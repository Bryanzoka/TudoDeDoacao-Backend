<?php

namespace App\Application\Dtos\Messages;

class CreateMessageDto
{
    public int $senderId;
    public int $recipientId;
    public string $text;

    private function __construct(int $senderId, int $recipientId, string $text)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->text = $text;
    }

    public static function create(int $senderId, int $recipientId, string $text)
    {
        return new self($senderId, $recipientId, $text);
    }
}