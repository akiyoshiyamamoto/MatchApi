<?php

namespace App\Http\Resources;

use App\Domain\User\Entities\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var User $user */
        $user = $this->resource;
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'latitude' => $user->getLatitude(),
            'longitude' => $user->getLongitude(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(201);
    }
}
