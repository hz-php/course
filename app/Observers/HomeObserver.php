<?php

namespace App\Observers;

class HomeObserver
{
    public function created()
    {
        \Cache::forget('homes');
    }
}
