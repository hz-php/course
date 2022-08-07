<?php

namespace App\Observers;

use Illuminate\Support\Facades\Redis;

class FavoriteObserver
{
    /**
     * Handle the Favorite "created" event.
     *
     *  * @return void
     */
    public function created()
    {
        $user_id = \Auth::id();
        Redis::del('favorite' . ' ' . $user_id);
    }
}
