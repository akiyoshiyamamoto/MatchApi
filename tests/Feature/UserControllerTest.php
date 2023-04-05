<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
    }

    public function test_show()
    {
        $user = $this->createTestUser();
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
        $user = $this->createTestUser();
        $token = JWTAuth::fromUser($user);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
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

    private function createTestUser(): User
    {
        $uniqueId = uniqid();
        return $this->userRepository->create(
            'Test User ' . $uniqueId,
            'test' . $uniqueId . '@example.com',
            bcrypt('password')
        );
    }

}
