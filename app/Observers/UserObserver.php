<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function creating(User $user)
    {
        $user->{$user->getKeyName()} = Uuid::uuid4()->toString();
        $user->api_token = $user->generateApiToken();
    }

    /**
     * Handle the user "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
