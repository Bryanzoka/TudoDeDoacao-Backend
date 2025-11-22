<?php

namespace App\Application\UseCases\Users;

use App\Application\Contracts\IEmailService;
use App\Application\Dtos\Users\VerificationCodeDto;
use App\Domain\Entities\VerificationCode;
use App\Domain\Repositories\IUserRepository;
use App\Domain\Repositories\IVerificationCodeRepository;
use Exception;

class SendVerificationCode
{
    private readonly IVerificationCodeRepository $codeRepository;
    private readonly IEmailService $emailService;
    private readonly IUserRepository $userRepository;

    public function __construct(IVerificationCodeRepository $codeRepository, IEmailService $emailService, IUserRepository $userRepository)
    {
        $this->codeRepository = $codeRepository;
        $this->emailService = $emailService;
        $this->userRepository = $userRepository;
    }

    public function handle(VerificationCodeDto $dto)
    {
        if ($this->userRepository->getByEmail($dto->email) != null) {
            throw new Exception('user with this email already exists', 400);
        }

        //delete the old code in repository
        if ($this->codeRepository->getByEmail($dto->email) != null) {
            $this->codeRepository->delete($this->codeRepository->getByEmail($dto->email));   
        }
        
        $code = VerificationCode::create($dto->email);
        
        $this->codeRepository->save($code);
        $this->emailService->send($code->getEmail(), 'verification code', $code->getCode());
    }
}