<?php

namespace App\Domain\Chat\Entities;

class Message
{
    private $id;
    private $chatId;
    private $senderId;
    private $content;
    private $createdAt;

    public function __construct($id, $chatId, $senderId, $content, $createdAt)
    {
        $this->id = $id;
        $this->chatId = $chatId;
        $this->senderId = $senderId;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    // Getters and setters...
}
