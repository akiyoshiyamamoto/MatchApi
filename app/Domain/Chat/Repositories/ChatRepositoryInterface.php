<?php

namespace App\Domain\Chat\Repositories;

use App\Domain\Chat\Entities\Chat;

interface ChatRepositoryInterface
{
    /**
     * Get a Chat by its ID.
     *
     * @param int $id
     * @return Chat|null
     */
    public function getById(int $id): ?Chat;

    /**
     * Save a Chat to the repository.
     *
     * @param Chat $chat
     * @return Chat
     */
    public function save(Chat $chat): Chat;
    public function getConversation(int $userId, int $partnerId): array;
    public function store(array $data): Chat;
    public function updateReadStatus(int $id, bool $isRead): bool;

}
