<?php

namespace Database\Factories;

use App\Domain\User\Entities\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use PDO;

class UserFactory
{
    private Faker $faker;
    private PDO $connection;

    public function __construct(Faker $faker,  PDO $connection)
    {
        $this->faker = $faker;
        $this->connection = $connection;
    }

    public function create(array $attributes = []): User
    {
        $id = $attributes['id'] ?? null;
        $name = $attributes['name'] ?? $this->faker->name;
        $email = $attributes['email'] ?? $this->faker->unique()->safeEmail;
        $password = $attributes['password'] ?? 'password123';
        $longitude = $attributes['longitude'] ?? $this->faker->latitude(-90, 90);
        $latitude = $attributes['latitude'] ?? $this->faker->longitude(-180, 180);
        $created_at = $attributes['created_at'] ?? $this->faker->dateTime;
        $updated_at = $attributes['updated_at'] ?? $this->faker->dateTime;

        return new User(
            $id,
            $name,
            $email,
            $password,
            $created_at,
            $updated_at,
            $longitude,
            $latitude,
        );
    }

    public function createAndPersist(array $attributes = []): User
    {
        $user = $this->create($attributes);

        // Insert the user data into the database using PDO
        $statement = $this->connection->prepare(
            'INSERT INTO users (name, email, password, created_at, updated_at, latitude, longitude) VALUES (:name, :email, :password, :created_at, :updated_at, :latitude, :longitude)'
        );
        $statement->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => Hash::make($user->getPassword()),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s'),
            ':longitude' => number_format($user->getLongitude(),6),
            ':latitude' => number_format($user->getLatitude(), 6),
        ]);

        $id = (int)$this->connection->lastInsertId();
        $user->setId($id);

        return $user;
    }
}
