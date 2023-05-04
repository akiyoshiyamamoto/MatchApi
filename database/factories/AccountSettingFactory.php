<?php

namespace Database\Factories;

use App\Domain\AccountSetting\Entities\AccountSetting;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\DB;

class AccountSettingFactory
{
    public function create(): AccountSetting
    {
        $faker = FakerFactory::create();

        $accountSetting = new AccountSetting(
            $faker->randomNumber(),
            $faker->randomNumber(),
        );

        DB::table('account_settings')->insert([
            'id' => $accountSetting->getId(),
            'user_id' => $accountSetting->getUserId(),
        ]);

        return $accountSetting;
    }
}

