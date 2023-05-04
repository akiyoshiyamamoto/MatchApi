<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\AccountSetting\Repositories\AccountSettingRepositoryInterface;
use App\Domain\AccountSetting\Services\AccountSettingService;
use Database\Factories\AccountSettingFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountSettingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private AccountSettingRepositoryInterface $accountSettingRepository;
    private AccountSettingService $accountSettingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountSettingRepository = $this->createMock(AccountSettingRepositoryInterface::class);
        $this->accountSettingService = new AccountSettingService($this->accountSettingRepository);
    }

    public function test_get_account_setting()
    {
        $accountSetting = (new AccountSettingFactory())->create();

        $this->accountSettingRepository->expects($this->once())
            ->method('getAccountSettingByUserId')
            ->with($accountSetting->getUserId())
            ->willReturn($accountSetting);

        $response = $this->getJson("/api/account-settings/{$accountSetting->getUserId()}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $accountSetting->getId(),
                'user_id' => $accountSetting->getUserId(),
                'name' => $accountSetting->getName(),
                'email' => $accountSetting->getEmail(),
            ]);
    }
}
