<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Users\LoginDto;
use App\Application\Dtos\Users\LogoutDto;
use App\Application\Dtos\Users\VerificationCodeDto;
use App\Http\Requests\Users\RefreshRequest;
use App\Application\UseCases\Users\RefreshToken;
use App\Application\UseCases\Users\Login;
use App\Application\UseCases\Users\Logout;
use App\Application\UseCases\Users\SendVerificationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\LogoutRequest;
use App\Http\Requests\Users\VerificationCodeRequest;
use Exception;

class AuthController extends Controller
{
    public function login(LoginRequest $request, Login $useCase)
    {   
        $data = $request->validated();
        try {
            $tokens = $useCase->handle(LoginDto::create($data['email'], $data['password']));

            return response()->json(['access_token' => $tokens['access_token'], 'refresh_token' => $tokens['refresh_token']], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function refresh(RefreshRequest $request, RefreshToken $useCase)
    {
        $data = $request->validated();
        try {
            $tokens = $useCase->handle($data['token']);
            return response()->json(['access_token' => $tokens['access_token'], 'refresh_token' => $tokens['refresh_token']], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function logout(LogoutRequest $request, Logout $useCase)
    {
        $data = $request->validated();
        $useCase->handle(LogoutDto::create($data['token']));
        return response()->json(null, 204);
    }   

    public function requestCode(VerificationCodeRequest $request, SendVerificationCode $useCase)
    {   
        $data = $request->validated();
        try {
            $useCase->handle(VerificationCodeDto::create($data['email']));
            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
