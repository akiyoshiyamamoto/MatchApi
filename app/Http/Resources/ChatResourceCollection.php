<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(fn($chat) => new ChatResource($chat))->all();
    }
}
