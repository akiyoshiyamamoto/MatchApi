<?php

namespace App\Domain\Swipe\Repositories;

use App\Domain\Swipe\Entities\Swipe;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use PDO;

class PDOSwipeRepository implements SwipeRepositoryInterface
{
    protected $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    public function create(int $swiperId, int $swipedId, bool $liked): Swipe
    {
        $existingSwipe = $this->findBySwiperIdAndSwipedId($swiperId, $swipedId);

        if ($existingSwipe) {
            throw new \Exception('Swipe already exists.');
        }

        $id = DB::table('swipes')->insertGetId([
            'swiper_id' => $swiperId,
            'swiped_id' => $swipedId,
            'liked' => $liked,
        ]);

        return new Swipe($id, $swiperId, $swipedId, $liked);
    }

    public function findBySwiperIdAndSwipedId(int $swiperId, int $swipedId): ?Swipe
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM swipes WHERE swiper_id = :swiper_id AND swiped_id = :swiped_id'
        );
        $statement->execute([
            ':swiper_id' => $swiperId,
            ':swiped_id' => $swipedId,
        ]);

        $swipeData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($swipeData) {
            return Swipe::fromArray($swipeData);
        }

        return null;
    }

}
