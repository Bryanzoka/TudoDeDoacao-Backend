<?php

namespace App\Application\UseCases\Messages;

use App\Application\Dtos\Messages\GetMessagesDto;
use App\Domain\Repositories\IMessageRepository;
use Exception;

class GetMessages
{
    private readonly IMessageRepository $messageRepository;

    public function __construct(IMessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function handle(GetMessagesDto $dto)
    {
        if ($dto->senderId == $dto->recipientId) {
            throw new Exception('sender and recipient id are equals', 400);
        }

        return $this->messageRepository->getByUsersIds($dto->senderId, $dto->recipientId, $dto->limit, $dto->offset)
            ?? throw new Exception('messages not found', 404);
    }
}