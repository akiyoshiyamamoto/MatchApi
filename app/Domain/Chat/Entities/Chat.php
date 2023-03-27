<?php

namespace App\Domain\Chat\Entities;

use DateTimeImmutable;

class Chat
{
    private int $id;
    private int $senderId;
    private int $receiverId;
    private string $message;
    private DateTimeImmutable $createdAt;

    public function __construct(
        int $id = null,
        int $senderId,
        int $receiverId,
        string $message,
        DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->message = $message;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
