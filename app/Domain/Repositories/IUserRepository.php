<?php

namespace App\Domain\Repositories;

use App\Models\User;

interface IUserRepository
{
    public function getAllUsers();
    public function create(array $data);
    public function getById(int $id);
    public function updateUser(User $user, array $data);
    public function deleteUser(User $user);
}