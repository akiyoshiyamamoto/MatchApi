<?php

namespace App\Domain\Swipe\Repositories;

use App\Domain\Swipe\Entities\Swipe;
use Illuminate\Support\Facades\DB;

class PDOSwipeRepository implements SwipeRepositoryInterface
{
    public function create(int $swiperId, int $swipedId, bool $liked): Swipe
    {
        $id = DB::table('swipes')->insertGetId([
            'swiper_id' => $swiperId,
            'swiped_id' => $swipedId,
            'liked' => $liked,
        ]);

        return new Swipe($id, $swiperId, $swipedId, $liked);
    }
}
