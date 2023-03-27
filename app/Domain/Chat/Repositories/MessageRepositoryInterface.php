<?php

namespace App\Domain\Chat\Repositories;

interface MessageRepositoryInterface
{
    public function getByChatId($chatId);
    public function create($chatId, $senderId, $content);
}
