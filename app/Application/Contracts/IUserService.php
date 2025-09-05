<?php

namespace App\Application\Contracts;

use Illuminate\Http\UploadedFile;

interface IUserService
{
    public function createUser(array $data);
    public function getUserById(int $id);
}