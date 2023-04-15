<?php

namespace Database\Factories;

use App\Domain\Notification\Entities\Notification;
use Faker\Generator as Faker;
use PDO;

class NotificationFactory
{
    private Faker $faker;
    private PDO $connection;

    public function __construct(Faker $faker, PDO $connection)
    {
        $this->faker = $faker;
        $this->connection = $connection;
    }

    public function create(array $attributes = []): Notification
    {
        $id = $attributes['id'] ?? null;
        $userId = $attributes['user_id'];
        $message = $attributes['message'] ?? $this->faker->sentence;
        $isRead = $attributes['is_read'] ?? false;
        $createdAt = $attributes['created_at'] ?? $this->faker->dateTime;
        $updatedAt = $attributes['updated_at'] ?? $this->faker->dateTime;

        return new Notification(
            $id,
            $userId,
            $message,
            $isRead,
            $createdAt,
            $updatedAt
        );
    }

    public function createAndPersist(array $attributes = []): Notification
    {
        $notification = $this->create($attributes);

        // Insert the notification data into the database using PDO
        $statement = $this->connection->prepare(
            'INSERT INTO notifications (user_id, message, is_read, created_at, updated_at) VALUES (:user_id, :message, :is_read, :created_at, :updated_at)'
        );
        $statement->execute([
            ':user_id' => $notification->getUserId(),
            ':message' => $notification->getMessage(),
            ':is_read' => $notification->getIsRead() ? 1 : 0,
            ':created_at' => $notification->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $notification->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);

        $id = (int)$this->connection->lastInsertId();
        $notification->setId($id);

        return $notification;
    }
}
