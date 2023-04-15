<?php

namespace App\Domain\Notification\Repositories;

use App\Domain\Notification\Entities\Notification;

interface NotificationRepositoryInterface
{
    public function findNewMatchNotifications(int $userId): array;
}
