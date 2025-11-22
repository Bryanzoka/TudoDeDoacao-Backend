<?php

namespace App\Application\UseCases\Users;

use App\Application\Dtos\Users\CreateUserDto;
use App\Domain\Repositories\IUserRepository;
use App\Domain\Repositories\IVerificationCodeRepository;
use App\Domain\Entities\User;
use Exception;

class CreateUser
{
    private readonly IUserRepository $userRepository;
    private readonly IVerificationCodeRepository $codeRepository;

    public function __construct(IUserRepository $userRepository, IVerificationCodeRepository $codeRepository)
    {
        $this->userRepository = $userRepository;
        $this->codeRepository = $codeRepository;
    }

    public function handle(CreateUserDto $dto)
    {
        $code = $this->codeRepository->getByEmail($dto->email) ?? throw new Exception('no verification code found for this email', 404);

        if ($code->isExpired()) {
            $this->codeRepository->delete($code);
            throw new Exception('expired code', 400);
        }

        if (!$code->validateCode($dto->code)) {
            throw new Exception('invalid code', 400);
        }

        $imagePath = null;

        if ($dto->profileImage) {
            $imagePath = $dto->profileImage->store('users', 'public');
        }

        $this->codeRepository->delete($code);
        
        return $this->userRepository->create(User::create(
            null,
            $dto->name,
            $dto->email,
            $dto->phone,
            $imagePath,
            $dto->password,
            $dto->location,
            $dto->role
        ));
    }
}