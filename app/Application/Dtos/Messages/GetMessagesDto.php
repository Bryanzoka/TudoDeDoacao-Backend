<?php

namespace App\Application\Dtos\Messages;

class GetMessagesDto
{
    public int $senderId;
    public int $recipientId;
    public int $limit;
    public int $offset;

    private function __construct(int $senderId, int $recipientId, int $limit, int $offset)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public static function create(int $senderId, int $recipientId, int $limit, int $offset)
    {
        return new self($senderId, $recipientId, $limit, $offset);
    }
}