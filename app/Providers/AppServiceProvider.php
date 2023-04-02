<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PDO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PDO::class, function ($app) {
            // 環境を判定して設定を切り替える
            $config = $app['config']['database.connections.' . env('DB_CONNECTION', 'mysql')];
            $dsn = $config['driver'] . ':host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['database'] . ';charset=utf8mb4';
            $username = $config['username'];
            $password = $config['password'];
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            return new PDO($dsn, $username, $password, $options);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
