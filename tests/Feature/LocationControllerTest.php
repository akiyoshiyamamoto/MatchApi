<?php

namespace Tests\Feature;

use App\Domain\Location\Repositories\LocationRepositoryInterface;
use Database\Factories\UserFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use PDO;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private LocationRepositoryInterface $locationRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdoInstance = App::make(PDO::class);
        $this->locationRepository = $this->app->make(LocationRepositoryInterface::class);
    }

    public function testUpdateLocation(): void
    {
        $user = (new UserFactory(FakerFactory::create(), $this->pdoInstance))->createAndPersist(['password' => '1234']);
        $token = $this->authenticateUser($user);

        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/location', [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'user_id',
                'latitude',
                'longitude',
            ]
        ]);

        $responseData = $response->json('data');
        $this->assertEquals($user->getId(), $responseData['user_id']);
        $this->assertEquals($latitude, $responseData['latitude']);
        $this->assertEquals($longitude, $responseData['longitude']);
    }

    private function authenticateUser($user)
    {
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password', // これは createUser メソッドで設定したパスワードと同じにしてください。
        ]);

        $response->assertStatus(200);

        return $response->json('access_token');
    }
}
