<?php

namespace App\Domain\Repositories;

use App\Http\Requests\UserRequests\UserUpdateRequest;

interface IUserRepository
{
    public function getAllUsers();
    public function create(array $data);
    public function getById(int $id);
    public function updateUser(array $user);
}