<?php

namespace App\Domain\Location\Entities;

class Location
{
    private int $id;
    private int $userId;
    private float $latitude;
    private float $longitude;

    public function __construct(int $id, int $userId, float $latitude, float $longitude)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
