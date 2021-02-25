<?php

namespace Baconfy\Traits\Loaders;

use File;

trait ConfigurationTrait
{
    /**
     * @param $directory
     * @return void
     */
    protected function loadModuleConfiguration($directory)
    {
        $directory = $this->getClassDirectory($directory);

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                $this->mergeConfigFrom($file->getPathname(), $file->getBasename('.php'));
            }
        }
    }
}