<?php

namespace App\Http\Controllers\Api;

use App\Application\Contracts\IUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\UserRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    private readonly IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return response()->json(['users' => $users], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        return response()->json(['user' => $user], 201);
    }

    public function show(int $id)
    {
        try {
            return $this->userService->getUserById($id, (int)auth()->id());
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(UserUpdateRequest $request, int $id)
    {
        try {
            return $this->userService->updateUser($request->validated(), $id, (int)auth()->id());
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userService->deleteUser($id, (int)auth()->id());
            return response(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
