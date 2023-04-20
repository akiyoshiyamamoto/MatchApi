<?php

namespace Tests\Feature\Http\Controllers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use Database\Factories\UserFactory;
use DateTime;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserControllerTest extends TestCase
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

    public function test_show()
    {
        $user = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->get('/api/user');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                ]
            ]);
    }

    public function test_update()
    {
        $user = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);
        $token = JWTAuth::fromUser($user);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->put('/api/user', $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->getId(),
                    'name' => $updatedData['name'],
                    'email' => $updatedData['email'],
                ]
            ]);
    }

    public function test_nearby_users()
    {
        // Create users with location data
        $user1 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))
            ->createAndPersist([
                'latitude' => 35.6895,
                'longitude' => 139.6917,
                'password' => '1234',
            ]);

        $user2 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))
            ->createAndPersist([
                'latitude' => 35.6896,
                'longitude' => 139.6918,
            ]);

        $user3 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))
            ->createAndPersist([
                'latitude' => 35.7000,
                'longitude' => 139.7000,
            ]);

        $token = JWTAuth::fromUser($user1);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->json('GET', '/api/user/nearby-users', [
                'latitude' => $user1->getLatitude(),
                'longitude' => $user1->getLongitude(),
                'radius' => 0.1,
            ]);


        $response->assertStatus(200);
        $this->assertSame($user1->getId(), $response['data'][0]['id']);
        $this->assertSame($user2->getId(), $response['data'][1]['id']);
    }

    public function test_matched_users()
    {
        // Create three users
        $user1 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))
            ->createAndPersist(['password' => '1234']);
        $user2 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))
            ->createAndPersist();
        $user3 = (new UserFactory(FakerFactory::create(), $this->pdoInstance))
            ->createAndPersist();

        // Insert matching data
        $this->insertMatchingData($user1->getId(), $user2->getId());
        $this->insertMatchingData($user1->getId(), $user3->getId());

        $token = JWTAuth::fromUser($user1);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->json('GET', '/api/user/matched-users');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id' => $user2->getId(),
                    'name' => $user2->getName(),
                    'email' => $user2->getEmail(),
                ],
                [
                    'id' => $user3->getId(),
                    'name' => $user3->getName(),
                    'email' => $user3->getEmail(),
                ],
            ],
        ]);
    }

    private function insertMatchingData(int $userId, int $matchedUserId)
    {
        $stmt = $this->pdoInstance->prepare("
        INSERT INTO matches (user1_id, user2_id, created_at, updated_at)
        VALUES (:user1_id, :user2_id, :created_at, :updated_at)
    ");
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $stmt->execute([
            ':user1_id' => $userId,
            ':user2_id' => $matchedUserId,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);
    }

}
