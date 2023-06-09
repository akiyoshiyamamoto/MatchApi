<?php

namespace App\Providers;

use App\Domain\AccountSetting\Repositories\PDOAccountSettingRepository;
use App\Domain\AccountSetting\Repositories\AccountSettingRepositoryInterface;
use App\Domain\Chat\Repositories\ChatRepositoryInterface;
use App\Domain\Chat\Repositories\MessageRepositoryInterface;
use App\Domain\Chat\Repositories\PDOChatRepository;
use App\Domain\Location\Repositories\LocationRepositoryInterface;
use App\Domain\Location\Repositories\PDOLocationRepository;
use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\Notification\Repositories\PDONotificationRepository;
use App\Domain\Swipe\Repositories\PDOSwipeRepository;
use App\Domain\Swipe\Repositories\SwipeRepositoryInterface;
use App\Domain\User\Repositories\PDOUserRepository;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\PDOMessageRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ChatRepositoryInterface::class, PDOChatRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, PDOMessageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, PDOUserRepository::class);
        $this->app->bind(SwipeRepositoryInterface::class, PDOSwipeRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, PDOLocationRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, PDONotificationRepository::class);
        $this->app->bind(ChatRepositoryInterface::class, PDOChatRepository::class);
        $this->app->bind(AccountSettingRepositoryInterface::class, PDOAccountSettingRepository::class);
    }

    public function boot()
    {
        //
    }
}
