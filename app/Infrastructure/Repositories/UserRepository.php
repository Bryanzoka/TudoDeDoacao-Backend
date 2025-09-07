<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }
  
    public function create(array $data)
    {
        return User::create($data);
    }

    public function getById(int $id)
    {
        return User::find($id);
    }
}