<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PDO;
use Tymon\JWTAuth\Facades\JWTAuth;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;



    protected function setUp(): void
    {
        parent::setUp();
        $this->app->singleton(JWTAuth::class, function($app) {
            return new JWTAuth($app['tymon.jwt.manager'], $app['tymon.jwt.provider.user'], $app['tymon.jwt.provider.jwt'], $app['request']);
        });
        $this->pdoInstance = App::make(PDO::class);

    }

    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}
