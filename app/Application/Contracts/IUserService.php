<?php

namespace App\Application\Contracts;

interface IUserService
{
    public function getAllUsers();
    public function getUserById(int $id, int $jwtUserId);
    public function createUser(array $data);
    public function updateUser(array $data, int $id, int $jwtUserId);
    public function deleteUser(int $id, int $jwtUserId);
}