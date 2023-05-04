<?php

namespace App\Infrastructure;

use App\Database\Connection;
use App\Domain\Chat\Entities\Message;
use App\Domain\Chat\Repositories\MessageRepositoryInterface;
use PDO;

class PDOMessageRepository implements MessageRepositoryInterface
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::make();
    }

    public function getByChatId($chatId): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM messages WHERE chat_id = :chat_id');
        $stmt->bindParam(':chat_id', $chatId, PDO::PARAM_INT);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($message) {
            return new Message(
                $message['id'],
                $message['chat_id'],
                $message['sender_id'],
                $message['content'],
                $message['created_at']
            );
        }, $messages);
    }


    public function create($chatId, $senderId, $content): void
    {
        $stmt = $this->connection->prepare('INSERT INTO messages (chat_id, sender_id, content) VALUES (:chat_id, :sender_id, :content)');
        $stmt->bindParam(':chat_id', $chatId, PDO::PARAM_INT);
        $stmt->bindParam(':sender_id', $senderId, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
    }
}
