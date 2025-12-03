<?php

namespace App\Domain\Entities;

use DateTimeImmutable;

class Message
{
    private ?int $id;
    private int $senderId;
    private int $recipientId;
    private string $text;
    private ?DateTimeImmutable $readAt;

    private function __construct(?int $id, int $senderId, int $recipientId, string $text, ?DateTimeImmutable $readAt)
    {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->text = $text;
        $this->readAt = $readAt;
    }

    public static function create(int $senderId, int $recipientId, string $text)
    {
        return new self(null, $senderId, $recipientId, $text, null);
    }

    public static function restore(int $id, int $senderId, int $recipientId, string $text, ?DateTimeImmutable $readAt)
    {
        return new self($id, $senderId, $recipientId, $text, $readAt);
    }

    public function read()
    {
        $this->readAt = new DateTimeImmutable();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function getRecipientId()
    {
        return $this->recipientId;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getReadAt()
    {
        return $this->readAt;
    }
}