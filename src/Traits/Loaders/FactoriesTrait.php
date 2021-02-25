<?php

namespace Baconfy\Traits\Loaders;

use File;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

trait FactoriesTrait
{
    /**
     * @param $directory
     */
    protected function loadModuleFactories($directory)
    {
        $directory = $this->getClassDirectory($directory);

        if (File::isDirectory($directory)) {
            $this->app->singleton(Factory::class, function ($app) use ($directory) {
                return Factory::construct($this->app->make(Generator::class), $directory);
            });
        }
    }
}