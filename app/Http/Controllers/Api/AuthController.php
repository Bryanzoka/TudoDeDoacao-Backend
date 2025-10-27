<?php

namespace App\Http\Controllers\Api;

use App\Application\Contracts\IAuthService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private readonly IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }
    
    public function login(Request $request)
    {   
        try {
            $credentials = $request->only('email','password');
            $token = $this->authService->generateToken($credentials);

            return response()->json(['token' => $token]);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(null, 204);
    }

    public function requestCode(Request $request)
    {   
        try {
            $email = $request->validate(['email' => 'required|email']);
            $this->authService->requestVerificationCode($email['email']);
            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
