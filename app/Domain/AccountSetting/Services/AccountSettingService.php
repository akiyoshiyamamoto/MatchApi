<?php

namespace App\Domain\AccountSetting\Services;

use App\Domain\AccountSetting\Entities\AccountSetting;
use App\Domain\AccountSetting\Repositories\AccountSettingRepositoryInterface;

class AccountSettingService
{
    private AccountSettingRepositoryInterface $accountSettingRepository;

    public function __construct(AccountSettingRepositoryInterface $accountSettingRepository)
    {
        $this->accountSettingRepository = $accountSettingRepository;
    }

    public function getAccountSettingByUserId(int $userId): ?AccountSetting
    {
        return $this->accountSettingRepository->getAccountSettingByUserId($userId);
    }
}
