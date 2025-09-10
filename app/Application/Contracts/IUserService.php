<?php

namespace App\Application\Contracts;

interface IUserService
{
    public function getAllUsers();
    public function createUser(array $data);
    public function getUserById(int $id);
    public function updateUser(array $data, int $id);
}