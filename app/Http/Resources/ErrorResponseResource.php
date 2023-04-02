<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResponseResource extends JsonResource
{
    private $statusCode;

    public function __construct($resource, int $statusCode)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }

    public function toArray($request)
    {
        return [
            'message' => $this->message,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
