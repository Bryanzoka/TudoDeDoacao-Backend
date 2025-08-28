<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\UserRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private readonly UserService $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }
    
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userservice->register($request->validated());
        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token, 'user' => new UserResource($user)])->setStatusCode(201);
    }
    
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        if (auth()->id() != $user->id) {
            return response()->json(['message' => 'invalid operation, login not matching'], 401);
        }

        $user->update($request->validated());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        if (auth()->id() != $user->id) {
            return response()->json(['message' => 'invalid operation, login not matching'], 401);
        }

        $user->delete();
        return response(null, 204);
    }
}
