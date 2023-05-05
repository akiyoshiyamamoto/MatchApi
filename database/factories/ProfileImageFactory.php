<?php

namespace Database\Factories;

use App\Domain\User\Entities\ProfileImage;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class ProfileImageFactory
{
    private Faker $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function create(int $userId,): ProfileImage
    {
        DB::table('profile_images')->insert([
            'user_id' => $userId,
            'path' => $this->faker->text,
        ]);

        return new ProfileImage(
            DB::table('profile_images')->first()->id,
            $userId,
            $this->faker->text,
        );
    }
}
