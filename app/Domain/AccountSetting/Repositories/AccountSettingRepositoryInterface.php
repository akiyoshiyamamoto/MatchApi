<?php

namespace App\Domain\AccountSetting\Repositories;

use App\Domain\AccountSetting\Entities\AccountSetting;

interface AccountSettingRepositoryInterface
{
    public function getAccountSettingByUserId(int $userId): ?AccountSetting;
}
