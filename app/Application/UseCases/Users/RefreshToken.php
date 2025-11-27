<?php 

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IRefreshTokenRepository;
use App\Infrastructure\Models\UserModel;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshToken
{
    private readonly IRefreshTokenRepository $tokenRepository;

    public function __construct(IRefreshTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function handle(string $refreshToken)
    {
        $token = $this->tokenRepository->getByToken($refreshToken) ?? throw new Exception('token not found', 404);
        $userModel = UserModel::where('id', '=', $token->getUserId())->first();

        try {
            $newToken = $token->refresh();
        } catch (Exception $ex) {
            //token has expired
            $this->tokenRepository->delete($token);
            throw new Exception($ex->getMessage(), 400);
        }
        
        $acessToken = JWTAuth::fromUser($userModel);

        $this->tokenRepository->create($newToken);
        $this->tokenRepository->delete($token);

        return [
            'acess_token' => $acessToken,
            'refresh_token' => $newToken->getToken()
        ];
    }
}