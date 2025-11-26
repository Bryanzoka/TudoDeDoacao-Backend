<?php

namespace App\Domain\Entities;

class Donation
{
    private ?int $id;
    private int $userId;
    private string $name;
    private string $searchName;
    private ?string $description;
    private ?string $briefDescription;
    private string $category;
    private ?string $image;
    private string $location;
    private string $status;

    private function __construct(?int $id, int $userId, string $name, string $searchName, ?string $description, ?string $briefDescription, string $category, ?string $image, string $location, string $status)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->searchName = $searchName;
        $this->description = $description;
        $this->briefDescription = $briefDescription;
        $this->category = $category;
        $this->image = $image;
        $this->location = $location;
        $this->status = $status;
    }

    public static function create(int $userId, string $name, ?string $description, string $category, ?string $image, string $location)
    {
        $searchName =  strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $name));
        $briefDescription = str_split($description, 40)[0] . '...';

        return new self(null, $userId, $name, $searchName, $description, $briefDescription, $category, $image, $location, 'active');
    }

    public function update(string $name, ?string $description, string $category, ?string $image, string $location, string $status)
    {
        $searchName = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $name));
        $briefDescription = str_split($description, 40)[0] . '...';

        $this->name = $name;
        $this->searchName = $searchName;
        $this->description = $description;
        $this->briefDescription = $briefDescription;
        $this->category = $category;
        $this->image = $image;
        $this->location = $location;
        $this->status = strtolower($status);
    }

    public static function restore(int $id, int $userId, string $name, string $searchName, ?string $description, ?string $briefDescription, string $category, ?string $image, string $location, string $status)
    {
        return new self($id, $userId, $name, $searchName, $description, $briefDescription, $category, $image, $location, $status);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSearchName()
    {
        return $this->searchName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getBriefDescription()
    {
        return $this->briefDescription;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getStatus()
    {
        return $this->status;
    }
}