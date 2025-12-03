<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Message;

interface IMessageRepository
{
    public function getById(int $id): ?Message;
    public function getByUsersIds(int $senderId, int $recipientId, int $limit = 25, int $offset = 0): array;
    public function create(Message $message): void;
    public function update(Message $message): void;
}