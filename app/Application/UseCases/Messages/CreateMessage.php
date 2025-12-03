<?php

namespace App\Application\UseCases\Messages;

use App\Application\Dtos\Messages\CreateMessageDto;
use App\Domain\Entities\Message;
use App\Domain\Repositories\IMessageRepository;
use App\Domain\Repositories\IUserRepository;
use Exception;

class CreateMessage
{
    private readonly IUserRepository $userRepository;
    private readonly IMessageRepository $messageRepository;

    public function __construct(IUserRepository $userRepository, IMessageRepository $messageRepository)
    {
        $this->userRepository = $userRepository;
        $this->messageRepository = $messageRepository;
    }

    public function handle(CreateMessageDto $dto)
    {
        if ($dto->recipientId == $dto->senderId) {
            throw new Exception('sender and recipient id does not equals', 400);
        }

        $this->userRepository->getById($dto->senderId) ?? throw new Exception('the user sender does not exists', 404);
        $this->userRepository->getById($dto->recipientId) ?? throw new Exception('recipient user not found', 404);

        $this->messageRepository->create(Message::create($dto->senderId, $dto->recipientId, $dto->text));
    }
}