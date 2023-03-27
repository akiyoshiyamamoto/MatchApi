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

    /**
     * Get all chats between two users.
     *
     * @param int $user1Id
     * @param int $user2Id
     * @return array
     */
    public function getChatsBetweenUsers(int $user1Id, int $user2Id): array;
}
