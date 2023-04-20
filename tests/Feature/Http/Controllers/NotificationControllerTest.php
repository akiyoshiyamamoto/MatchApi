<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use Database\Factories\NotificationFactory;
use Database\Factories\UserFactory;
use Faker\Factory as FakerFactory;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationControllerTest extends TestCase
{
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function test_new_match_notifications()
    {
        // Create a user and generate a JWT token
        $user = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);
        $token = JWTAuth::fromUser($user);

        // Create new match notifications for the user
        $notificationFactory = new NotificationFactory(FakerFactory::create(), $this->pdoInstance);
        $notification1 = $notificationFactory->createAndPersist(['user_id' => $user->getId(), 'is_read' => false]);
        $notification2 = $notificationFactory->createAndPersist(['user_id' => $user->getId(), 'is_read' => false]);

        // Send request to the API endpoint
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->json('GET', '/api/notifications/new-matches');

        // Assert the response status and the JSON structure
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'data' => [
                [
                    'id' => $notification1->getId(),
                    'user_id' => $notification1->getUserId(),
                    'message' => $notification1->getMessage(),
                    'is_read' => $notification1->getIsRead(),
                    'created_at' => $notification1->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updated_at' => $notification1->getUpdatedAt()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => $notification2->getId(),
                    'user_id' => $notification2->getUserId(),
                    'message' => $notification2->getMessage(),
                    'is_read' => $notification2->getIsRead(),
                    'created_at' => $notification2->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updated_at' => $notification2->getUpdatedAt()->format('Y-m-d H:i:s'),
                ],
            ],
        ]);
    }
}
