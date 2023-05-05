<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\AccountSetting\Repositories\AccountSettingRepositoryInterface;
use App\Domain\AccountSetting\Services\AccountSettingService;
use Database\Factories\AccountSettingFactory;
use Database\Factories\UserFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccountSettingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private AccountSettingRepositoryInterface $accountSettingRepository;
    private AccountSettingService $accountSettingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountSettingRepository = $this->app->make(AccountSettingRepositoryInterface::class);
        $this->accountSettingService = new AccountSettingService($this->accountSettingRepository);
    }

    public function test_get_account_setting()
    {
        $accountSetting = (new AccountSettingFactory())->create();

        $user = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->get("/api/account_settings/{$accountSetting->getUserId()}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $accountSetting->getId(),
                    'user_id' => $accountSetting->getUserId(),
                ]
            ]);
    }
}
