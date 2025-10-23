<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\Contracts\IUserService;
use App\Http\Requests\UserRequests\UserStoreRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use Exception;
use Mail;

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
            $users = $this->userService->getAll();
            return response()->json(['users' => $users], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function store(UserStoreRequest $request)
    {
        $user = $this->userService->create($request->validated());

        return response()->json(['user' => $user], 201);
    }

    public function show(int $id)
    {
        try {
            return $this->userService->getById($id, (int)auth()->id());
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(UserUpdateRequest $request, int $id)
    {
        try {
            return $this->userService->update($request->validated(), $id, (int)auth()->id());
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userService->delete($id, (int)auth()->id());
            return response(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
