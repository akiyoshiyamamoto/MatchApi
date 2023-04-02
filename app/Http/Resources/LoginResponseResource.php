<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResponseResource extends JsonResource
{
    public $access_token;

    public function __construct($token)
    {
        parent::__construct($token);
        $this->access_token = $token;
    }

    public function toArray($request)
    {
        return [
            'access_token' => $this->access_token,
        ];
    }
}
