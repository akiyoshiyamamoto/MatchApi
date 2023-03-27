<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getId(),
            'sender_id' => $this->resource->getSenderId(),
            'receiver_id' => $this->resource->getReceiverId(),
            'message' => $this->resource->getMessage(),
            'created_at' => $this->resource->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
