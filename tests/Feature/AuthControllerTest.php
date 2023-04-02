<?php

namespace Tests\Feature;

use App\Domain\User\Entities\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PDO;
use Tests\TestCase;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\App;


class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    private $user;
    private string $password;

    protected function setUp(): void
    {
        parent::setUp();
        $pdoInstance = App::make(PDO::class);
        $this->password = 'password123';
        $this->user = (new UserFactory(FakerFactory::create(), $pdoInstance))->createAndPersist(['password' => $this->password]);
    }
    public function test_register()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson(route('register'), $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_login()
    {
        $response = $this->postJson(route('login'), [
            'email' => $this->user->getEmail(),
            'password' => $this->password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                ],
            ]);
    }

    public function test_logout()
    {
        $response = $this->actingAs($this->user, 'api')->postJson(route('logout'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'message' => 'Logged out successfully.',
                ],
            ]);
    }
}
