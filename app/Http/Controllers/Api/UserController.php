<?php

namespace App\Http\Controllers\Api;

use App\Application\Contracts\IUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\UserRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private readonly IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        return response()->json(['user' => $user], 201);
    }

    public function show(int $id)
    {
        try {
            return $this->userService->getUserById($id);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), 404);
        }
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
