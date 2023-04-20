<?php

namespace App\Domain\Chat\Services;

use App\Domain\Chat\Entities\Chat;
use App\Domain\Chat\Repositories\ChatRepositoryInterface;

class ChatService
{
    private $chatRepository;

    public function __construct(ChatRepositoryInterface $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function getById($id)
    {
        return $this->chatRepository->getById($id);
    }

    public function store($data)
    {
        return $this->chatRepository->store($data);
    }

    public function getAllChatsForUser($userId)
    {
        return $this->chatRepository->getAllChatsForUser($userId);
    }

    public function getConversation(int $userId, int $partnerId): array
    {
        return $this->chatRepository->getConversation($userId, $partnerId);
    }

    public function addChat(Chat $chat): Chat
    {
        return $this->chatRepository->save($chat);
    }
}
