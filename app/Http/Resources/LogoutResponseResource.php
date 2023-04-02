<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogoutResponseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'message' => $this->resource['message'],
        ];
    }
}
