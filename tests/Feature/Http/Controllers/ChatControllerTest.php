<?php
namespace Tests\Feature\Http\Controllers;

use App\Domain\Chat\Services\ChatService;
use Database\Factories\ChatFactory;
use Database\Factories\UserFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    private ChatFactory $chatFactory;
    private ChatService $chatService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->chatFactory = $this->app->make(ChatFactory::class);
        $this->chatService = $this->app->make(ChatService::class);
    }

    public function testGetConversation(): void
    {

        $user1 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);
        $user2 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);

        // Create some test data
        $senderId = $user1->getId();
        $receiverId = $user2->getId();
        $chat1 = $this->chatFactory->create($senderId, $receiverId);
        $chat2 = $this->chatFactory->create($receiverId, $senderId);

        // Persist the test data
        $this->chatService->addChat($chat1);
        $this->chatService->addChat($chat2);

        $token = JWTAuth::fromUser($user1);

        // Call the API endpoint
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->get('/api/chats?partner_id=' . $receiverId);

        // Check the response
        $response->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    [
                        'id' => $chat1->getId(),
                        'sender_id' => $chat1->getSenderId(),
                        'receiver_id' => $chat1->getReceiverId(),
                        'message' => $chat1->getMessage(),
                        'created_at' => $chat1->getCreatedAt()->format('Y-m-d H:i:s'),
                        'updated_at' => $chat1->getUpdatedAt()->format('Y-m-d H:i:s'),
                    ],
                    [
                        'id' => $chat2->getId(),
                        'sender_id' => $chat2->getSenderId(),
                        'receiver_id' => $chat2->getReceiverId(),
                        'message' => $chat2->getMessage(),
                        'created_at' => $chat2->getCreatedAt()->format('Y-m-d H:i:s'),
                        'updated_at' => $chat2->getUpdatedAt()->format('Y-m-d H:i:s'),
                    ]
                ],
            ]);
    }
}
