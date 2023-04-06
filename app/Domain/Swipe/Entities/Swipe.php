<?php

namespace App\Domain\Swipe\Entities;

class Swipe
{
    private int $id;
    private int $swiperId;
    private int $swipedId;
    private bool $liked;

    public function __construct(int $id, int $swiperId, int $swipedId, bool $liked)
    {
        $this->id = $id;
        $this->swiperId = $swiperId;
        $this->swipedId = $swipedId;
        $this->liked = $liked;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSwiperId(): int
    {
        return $this->swiperId;
    }

    public function getSwipedId(): int
    {
        return $this->swipedId;
    }

    public function isLiked(): bool
    {
        return $this->liked;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['swiper_id'],
            $data['swiped_id'],
            (bool) $data['liked']
        );
    }
}
