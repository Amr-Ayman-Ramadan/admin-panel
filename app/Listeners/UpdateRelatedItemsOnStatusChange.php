<?php

namespace App\Listeners;

use App\Events\UserStatusChanged;


class UpdateRelatedItemsOnStatusChange
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserStatusChanged $event)
    {
        $user = $event->user;

        if ($user->status === 'inactive') {
            $user->courses()->update(['status' => 'inactive']);
        }
    }

}
