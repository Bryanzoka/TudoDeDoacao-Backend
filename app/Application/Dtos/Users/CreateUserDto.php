<?php

namespace App\Application\Dtos\Users;

use Illuminate\Http\UploadedFile;

class CreateUserDto
{
    public string $name;
    public string $email;
    public string $phone;
    public string $password;
    public string $location;
    public string $role;
    public ?UploadedFile $profileImage;
    public string $code;

    private function __construct(string $name, string $email, string $phone, string $password, string $location, string $role, ?UploadedFile $profileImage, string $code)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->location = $location;
        $this->role = $role;
        $this->profileImage = $profileImage;
        $this->code = $code;
    }

    public static function create(string $name, string $email, string $phone, string $password, string $location, string $role, ?UploadedFile $profileImage, string $code)
    {
        return new self(
            $name,
            $email,
            $phone,
            $password,
            $location,
            $role,
            $profileImage,
            $code
        );
    }
}

