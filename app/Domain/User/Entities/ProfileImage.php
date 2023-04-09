<?php


namespace App\Domain\User\Entities;

class ProfileImage
{
    private int $id;
    private int $userId;
    private string $path;

    public function __construct(int $id, int $userId, string $path)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->path = $path;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
