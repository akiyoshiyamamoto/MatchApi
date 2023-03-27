<?php

namespace App\Providers;

use App\Domain\Chat\Repositories\PDOChatRepository;
use App\Infrastructure\Repositories\PDOMessageRepository;
use Illuminate\Support\ServiceProvider;
use App\Domain\Chat\Repositories\ChatRepositoryInterface;
use App\Domain\Chat\Repositories\MessageRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ChatRepositoryInterface::class, PDOChatRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, PDOMessageRepository::class);
    }

    public function boot()
    {
        //
    }
}
