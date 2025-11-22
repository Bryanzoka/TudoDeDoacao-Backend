<?php

namespace App\Domain\Entities;

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $phone;
    private ?string $profileImage;
    private string $password;
    private string $location;
    private string $role;

    private function __construct(?int $id, string $name, string $email, string $phone, ?string $profileImage, string $password, string $location, string $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->profileImage = $profileImage;
        $this->password = $password;
        $this->location = $location;
        $this->role = $role;
    }

    public static function create(?int $id, string $name, string $email, string $phone, ?string $profileImage, string $password, string $location, string $role)
    {
        return new self($id, $name, $email, $phone,  $profileImage, $password, $location, $role);
    }

    public function update(string $name, string $email, string $phone, ?string $profileImage, string $password, string $location)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->profileImage = $profileImage;
        $this->password = $password;
        $this->location = $location;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getProfileImage()
    {
        return $this->profileImage;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getRole()
    {
        return $this->role;
    }
}