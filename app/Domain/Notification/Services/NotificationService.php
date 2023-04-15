<?php

namespace App\Domain\Notification\Services;

use App\Domain\Notification\Repositories\NotificationRepositoryInterface;

class NotificationService
{
    private $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getNewMatchNotifications(int $userId): array
    {
        return $this->notificationRepository->findNewMatchNotifications($userId);
    }
}
