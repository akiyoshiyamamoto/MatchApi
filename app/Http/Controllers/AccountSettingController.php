<?php

namespace App\Http\Controllers;

use App\Domain\AccountSetting\Services\AccountSettingService;
use App\Http\Requests\GetAccountSettingRequest;
use App\Http\Resources\AccountSettingResource;
use Illuminate\Http\JsonResponse;

class AccountSettingController extends Controller
{
    private AccountSettingService $accountSettingService;

    public function __construct(AccountSettingService $accountSettingService)
    {
        $this->accountSettingService = $accountSettingService;
    }

    public function getAccountSetting(int $userId): JsonResponse
    {
        $accountSetting = $this->accountSettingService->getAccountSettingByUserId($userId);

        if (!$accountSetting) {
            return response()->json(['message' => 'アカウント設定が見つかりませんでした。'], 404);
        }

        return (new AccountSettingResource($accountSetting))
            ->response()
            ->setStatusCode(200)
            ->header('Content-Type', 'application/json');
    }
}
