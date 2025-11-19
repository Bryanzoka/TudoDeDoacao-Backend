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
    
    public function getByEmail(string $email)
    {
        return User::where('email', '=', $email);
    }

    public function create(User $user)
    {
        $user->save();
        return $user;
    }

    public function update(User $user)
    {
        $user->save();
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}