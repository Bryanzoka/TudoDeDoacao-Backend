<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message'=> 'Credenciais inválidas'],401);
        }

        return response()->json($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message'=> 'logout realizado com sucesso'], 204);
    }
}
