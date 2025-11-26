<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Users\CreateUserDto;
use App\Application\Dtos\Users\UpdateUserDto;
use App\Application\UseCases\Users\CreateUser;
use App\Application\UseCases\Users\GetAll;
use App\Application\UseCases\Users\GetById;
use App\Http\Controllers\Controller;
use App\Application\UseCases\Users\Update;
use App\Application\UseCases\Users\Delete;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Exception;

class UserController extends Controller
{
    public function index(GetAll $useCase)
    {
        try {
            $users = $useCase->handle();
            return response()->json(['users' => UserResource::collection($users)], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function store(UserStoreRequest $request, CreateUser $useCase)
    {
        $data = $request->validated();
        try {
            $id = $useCase->handle(CreateUserDto::create(
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['password'],
                $data['location'],
                'user',
                $request->file('profile_image'),
                $data['code']
            ));

            return response()->json(['user' => $id], 201);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function show(int $id, GetById $useCase)
    {
        try {
            return response()->json(['user' => new UserResource($useCase->handle($id))], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(UserUpdateRequest $request, int $id, Update $useCase)
    {
        $data = $request->validated();
        try {
            $useCase->handle(UpdateUserDto::create(
                $id,
                $data['name'] ?? null,
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $data['password'] ?? null,
                $data['location'] ?? null,
                $request->profile_image ?? null
            ));
            
            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function destroy(int $id, Delete $useCase)
    {
        try {
            $useCase->handle($id);
            return response(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }
}
