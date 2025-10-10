<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IUserRepository;
use App\Domain\Models\User;

class UserRepository implements IUserRepository
{
    public function getAll()
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

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}