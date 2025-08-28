<?php 

namespace App\Services\Interfaces;

use App\Http\Requests\UserRequests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

interface IUserService
{
    public function register(array $data): User;
}