<?php

namespace App\Domain\Swipe\Repositories;

use App\Domain\Swipe\Entities\Swipe;

interface SwipeRepositoryInterface
{
    public function create(int $swiperId, int $swipedId, bool $liked): Swipe;
}
