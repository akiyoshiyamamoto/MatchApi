<?php

namespace App\Domain\Chat\Services;

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

    public function create($participants)
    {
        return $this->chatRepository->create($participants);
    }

    public function getAllChatsForUser($userId)
    {
        return $this->chatRepository->getAllChatsForUser($userId);
    }
}
