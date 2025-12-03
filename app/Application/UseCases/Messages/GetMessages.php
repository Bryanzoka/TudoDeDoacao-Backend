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
        return $this->messageRepository->getByUsersIds($dto->senderId, $dto->recipientId, $dto->limit, $dto->offset)
            ?? throw new Exception('messages not found', 404);
    }
}