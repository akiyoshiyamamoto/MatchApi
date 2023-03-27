<?php

namespace App\Domain\Chat\Services;

use App\Domain\Chat\Repositories\MessageRepositoryInterface;

class MessageService
{
    private $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $this->messageRepository;
    }

    public function getByChatId($chatId)
    {
        return $this->messageRepository->getByChatid($chatId);
    }

    public function create($chatId, $senderId, $content)
    {
        return $this->messageRepository->create($chatId, $senderId, $content);
    }
}
