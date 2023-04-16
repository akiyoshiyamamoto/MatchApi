<?php

namespace Database\Factories;

use App\Domain\Chat\Entities\Chat;
use DateTimeImmutable;
use Faker\Generator as Faker;

class ChatFactory
{
    private Faker $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function create(int $senderId, int $receiverId): Chat
    {
        $createdAt = $this->faker->dateTime;
        $updatedAt = $createdAt;

        return new Chat(
            $this->faker->unique()->numberBetween(1, 1000000),
            $senderId,
            $receiverId,
            $this->faker->text,
            new DateTimeImmutable($createdAt->format('Y-m-d H:i:s')),
            new DateTimeImmutable($updatedAt->format('Y-m-d H:i:s'))
        );
    }
}
