<?php

namespace App\Domain\AccountSetting\Repositories;

use App\Domain\AccountSetting\Entities\AccountSetting;
use Illuminate\Support\Facades\DB;

class AccountSettingRepository implements AccountSettingRepositoryInterface
{
    public function getAccountSettingByUserId(int $userId): ?AccountSetting
    {
        $result = DB::table('account_settings')->where('user_id', $userId)->first();

        if (!$result) {
            return null;
        }

        return new AccountSetting(
            $result->id,
            $result->user_id,
        );
    }
}
