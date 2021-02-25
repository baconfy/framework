<?php

namespace Baconfy\Routing;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Scheduling\Schedule;

abstract class ConsoleRouter
{
    /**
     * @param Schedule $schedule
     */
    public function schedule(Schedule $schedule)
    {
    }

    /**
     * @param Artisan $artisan
     * @return void
     */
    abstract public function map(Artisan $artisan);
}