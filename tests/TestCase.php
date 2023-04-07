<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\App;
use PDO;
use Tymon\JWTAuth\Facades\JWTAuth;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->singleton(JWTAuth::class, function($app) {
            return new JWTAuth($app['tymon.jwt.manager'], $app['tymon.jwt.provider.user'], $app['tymon.jwt.provider.jwt'], $app['request']);
        });
        $this->pdoInstance = App::make(PDO::class);

    }
}
