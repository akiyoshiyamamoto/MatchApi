<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($notification) {
            return new NotificationResource($notification);
        })->all();
    }
}
