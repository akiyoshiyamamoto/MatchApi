<?php

namespace App\Http\Resources;

use App\Domain\AccountSetting\Entities\AccountSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountSettingResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var AccountSetting $accountSetting */
        $accountSetting = $this->resource;
        return [
            'id' => $accountSetting->getId(),
            'user_id' => $accountSetting->getUserId(),
        ];
    }
}
