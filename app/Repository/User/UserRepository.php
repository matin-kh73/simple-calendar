<?php


namespace App\Repository\User;


use App\Models\User;
use App\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
