<?php

namespace Database\Factories;

use App\Domain\Chat\Entities\Chat;
use DateTimeImmutable;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

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

        DB::table('chats')->insert([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'is_read' => $this->faker->boolean,
            'message' => $this->faker->text,
        ]);

        return new Chat(
            DB::table('chats')->first()->id,
            $senderId,
            $receiverId,
            $this->faker->text,
            new DateTimeImmutable($createdAt->format('Y-m-d H:i:s')),
            new DateTimeImmutable($updatedAt->format('Y-m-d H:i:s'))
        );
    }
}
