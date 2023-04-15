<?php

namespace App\Http\Resources;

use App\Domain\Notification\Entities\Notification;
use App\Domain\User\Entities\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Notification $notification */
        $notification = $this->resource;
        return [
            'id' => $notification->getId(),
            'user_id' => $notification->getUserId(),
            'message' => $notification->getMessage(),
            'is_read' => $notification->getIsRead(),
            'created_at' => $notification->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $notification->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
