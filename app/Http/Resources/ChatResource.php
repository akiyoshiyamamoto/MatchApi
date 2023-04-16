<?php

namespace App\Http\Resources;

use App\Domain\Chat\Entities\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Chat $chat */
        $chat = $this->resource;
        return [
            'id' => $chat->getId(),
            'sender_id' => $chat->getSenderId(),
            'receiver_id' => $chat->getReceiverId(),
            'message' => $chat->getMessage(),
            'created_at' => $chat->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $chat->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
