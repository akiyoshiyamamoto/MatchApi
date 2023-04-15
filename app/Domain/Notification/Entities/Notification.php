<?php

namespace App\Domain\Notification\Entities;

class Notification
{
    private ?int $id;
    private int $userId;
    private string $massage;
    private bool $isRead;
    private \DateTime $createdAt;
    private \DateTime $updateAt;
    private string $message;
    private \DateTime $updatedAt;

    public function __construct(?int $id, int $userId, string $massage, bool $isRead, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->message = $massage;
        $this->isRead = $isRead;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getIsRead(): bool
    {
        return $this->isRead;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
