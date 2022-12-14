<?php

namespace App\Observers;

use Illuminate\Support\Facades\Redis;

class HomeObserver
{
    /**
     * Handle the Favorite "created" event.
     *
     *  * @return void
     */
    public function created()
    {
        Redis::flushdb('homes');
    }
}
