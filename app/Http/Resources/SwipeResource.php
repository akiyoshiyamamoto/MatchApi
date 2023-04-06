<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SwipeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getId(),
            'swiper_id' => $this->getSwiperId(),
            'swiped_id' => $this->getSwipedId(),
            'liked' => $this->isLiked(),
        ];
    }
}
