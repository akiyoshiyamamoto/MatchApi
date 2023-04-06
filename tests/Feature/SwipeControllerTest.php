<?php

namespace Tests\Feature;

use App\Domain\Swipe\Repositories\SwipeRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class SwipeControllerTest extends TestCase
{
    use RefreshDatabase;

    private UserRepositoryInterface $userRepository;
    private SwipeRepositoryInterface $swipeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
        $this->swipeRepository = $this->app->make(SwipeRepositoryInterface::class);
    }

    public function test_right_swipe()
    {
        $swiper = $this->createTestUser('Swiper', 'swiper@example.com');
        $swiped = $this->createTestUser('Swiped', 'swiped@example.com');
        $token = JWTAuth::fromUser($swiper);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->post('/api/swipes/right', ['swiped_id' => $swiped->getId()]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Swipe right successful',
                'data' => [
                    'swiper_id' => $swiper->getId(),
                    'swiped_id' => $swiped->getId(),
                    'liked' => true,
                ],
            ]);
    }

    public function test_left_swipe()
    {
        $swiper = $this->createTestUser('Swiper', 'swiper2@example.com');
        $swiped = $this->createTestUser('Swiped', 'swiped2@example.com');
        $token = JWTAuth::fromUser($swiper);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->post('/api/swipes/left', ['swiped_id' => $swiped->getId()]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Swipe left successful',
                'data' => [
                    'swiper_id' => $swiper->getId(),
                    'swiped_id' => $swiped->getId(),
                    'liked' => false,
                ],
            ]);
    }

    private function createTestUser(string $name, string $email): User
    {
        return $this->userRepository->create(
            $name,
            $email,
            bcrypt('password')
        );
    }
}
