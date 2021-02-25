<?php

namespace Baconfy\Traits\Loaders;

use File;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Scheduling\Schedule;

trait ConsoleTrait
{
    /**
     * @param $directory
     * @return void
     */
    private function loadModuleCommands($directory)
    {
        $directory = $this->getClassDirectory($directory);

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                $router = app(get_class($file));

                Artisan::starting(function ($artisan) use ($router) {
                    $router->map($artisan);
                });

                $this->app->booted(function () use ($router) {
                    $router->schedule($this->app->make(Schedule::class));
                });
            }
        }
    }
}