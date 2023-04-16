<?php

namespace App\Domain\Chat\Repositories;

use App\Domain\Chat\Entities\Chat;
use PDO;

class PDOChatRepository implements ChatRepositoryInterface
{
    protected $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $id): ?Chat
    {
        $statement = $this->connection->prepare('SELECT * FROM chats WHERE id = :id');
        $statement->execute([':id' => $id]);
        $chatData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($chatData === false) {
            return null;
        }

        return new Chat(
            $chatData['id'],
            $chatData['sender_id'],
            $chatData['receiver_id'],
            $chatData['message'],
            new \DateTimeImmutable($chatData['created_at']),
            new \DateTimeImmutable($chatData['updated_at'])
        );
    }

    public function save(Chat $chat): Chat
    {
        $statement = $this->connection->prepare(
            'INSERT INTO chats (sender_id, receiver_id, message, created_at, updated_at) VALUES (:sender_id, :receiver_id, :message, :created_at, :updated_at)'
        );

        $statement->execute([
            ':sender_id' => $chat->getSenderId(),
            ':receiver_id' => $chat->getReceiverId(),
            ':message' => $chat->getMessage(),
            ':created_at' => $chat->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $chat->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);

        $chat->setId($this->connection->lastInsertId());

        return $chat;
    }

    public function getConversation(int $userId, int $partnerId): array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM chats WHERE (sender_id = :userId AND receiver_id = :partnerId) OR (sender_id = :partnerId AND receiver_id = :userId) ORDER BY created_at ASC'
        );

        $statement->execute([
            ':userId' => $userId,
            ':partnerId' => $partnerId,
        ]);

        $chatsData = $statement->fetchAll(PDO::FETCH_ASSOC);
        $chats = [];

        foreach ($chatsData as $chatData) {
            $chats[] = new Chat(
                $chatData['id'],
                $chatData['sender_id'],
                $chatData['receiver_id'],
                $chatData['message'],
                new \DateTimeImmutable($chatData['created_at']),
                new \DateTimeImmutable($chatData['updated_at'])
            );
        }

        return $chats;
    }
}
