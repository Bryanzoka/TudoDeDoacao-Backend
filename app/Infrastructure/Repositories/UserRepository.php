<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IUserRepository;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Models\User;

class UserRepository implements IUserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getById(int $id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function updateUser(array $user)
    {
        return User::update($user);
    }
}