<?php

namespace App\Application\Contracts;

interface IUserService
{
    public function getAllUsers();
    public function createUser(array $data);
    public function getUserById(int $id);
}