<?php

namespace App\Domain\Notification\Repositories;

use App\Domain\Notification\Entities\Notification;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use PDO;

class PDONotificationRepository implements NotificationRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findNewMatchNotifications(int $userId): array
    {
        $stmt = $this->connection->prepare(
            "SELECT * FROM notifications WHERE user_id = :user_id AND is_read = 0 ORDER BY created_at DESC"
        );
        $stmt->execute([':user_id' => $userId]);

        $notificationsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $notifications = [];
        foreach ($notificationsData as $notificationData) {
            $notifications[] = $this->createNotificationFromData($notificationData);
        }

        return $notifications;
    }

    private function createNotificationFromData(array $data): Notification
    {
        return new Notification(
            (int)$data['id'],
            (int)$data['user_id'],
            $data['message'],
            (bool)$data['is_read'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at'])
        );
    }
}
