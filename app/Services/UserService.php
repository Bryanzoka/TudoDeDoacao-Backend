<?php

namespace App\Services;

use App\Http\Requests\UserRequests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function register(array $data): User
    {
         if (isset($data['profile_image'])) {
            $data['profile_image'] = $data['profile_image']->store('users', 'public');
        }   
        $user = User::create($data);
        return $user;
    }
}
