<?php


namespace App\Repository\Event;


use App\Models\Event;
use App\Repository\BaseRepository;

class EventRepository extends BaseRepository
{
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

    /**
     *
     *
     * @param $id
     * @param int $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function events($id, int $paginate = 15)
    {
        return $this->getQuery()->whereHas('user', function ($user) use ($id) {
            $user->whereId($id);
        })->with('user')->latest()->paginate($paginate);
    }
}
