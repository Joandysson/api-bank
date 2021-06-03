<?php

namespace App\Observers;

use App\Models\User;
use App\Utils\UserUtils;
use App\Utils\OpensslUtils;

class UserObserver
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user = UserUtils::encrypt($user);
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user = UserUtils::decrypt($user);
    }

    /**
     * Handle the User "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        $user = UserUtils::encrypt($user);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $user = UserUtils::decrypt($user);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(User $user)
    {
        $user = UserUtils::encrypt($user);
    }

    /**
     * Handle the User "saved" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saved(User $user)
    {
        $user = UserUtils::decrypt($user);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        $user = UserUtils::decrypt($user);
    }

    public function retrieved(User $user)
    {
        $user = UserUtils::decrypt($user);
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
    }

    public function getIncrementing()
    {
        return false;
    }
}
