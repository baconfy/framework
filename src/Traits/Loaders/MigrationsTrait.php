<?php

namespace Baconfy\Traits\Loaders;

use File;

trait MigrationsTrait
{
    /**
     * @param $directory
     */
    protected function loadModuleMigrations($directory)
    {
        $directory = $this->getClassDirectory($directory);

        if (File::isDirectory($directory)) {
            $this->loadMigrationsFrom($directory);
        }
    }
}