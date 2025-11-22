<?php

namespace App\Application\Dtos\Users;

use Illuminate\Http\UploadedFile;

class UpdateUserDto
{
    public int $id;
    public ?string $name;
    public ?string $email;
    public ?string $phone;
    public ?string $password;
    public ?string $location;
    public ?UploadedFile $profileImage;

    private function __construct(int $id, ?string $name, ?string $email, ?string $phone, ?string $password, ?string $location, ?UploadedFile $profileImage)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->location = $location;
        $this->profileImage = $profileImage;
    }

    public static function create(int $id, ?string $name, ?string $email, ?string $phone, ?string $password, ?string $location, ?UploadedFile $profileImage)
    {
        return new self(
            $id,
            $name,
            $email,
            $phone,
            $password,
            $location,
            $profileImage,
        );
    }
}