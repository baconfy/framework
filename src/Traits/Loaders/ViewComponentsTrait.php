<?php

namespace Baconfy\Traits\Loaders;

use File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Symfony\Component\Finder\SplFileInfo;

trait ViewComponentsTrait
{
    /**
     * Register the given component.
     *
     * @param string $directory
     * @return void
     */
    protected function loadModuleViewComponents(string $directory)
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) use ($directory) {
            $directory = $this->getClassDirectory($directory);

            if (File::isDirectory($directory)) {
                $files = File::allFiles($directory);

                foreach ($files as $file) {
                    list($alias, $class) = $this->sanitize($file);

                    $blade->component($class, $alias);
                }
            }
        });
    }

    /**
     * Register the given component.
     *
     * @param string $directory
     * @return void
     */
    protected function loadModuleViewComponentsFromDirectory(string $directory)
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) use ($directory) {
            if (File::isDirectory($directory)) {
                $files = File::allFiles($directory);

                foreach ($files as $file) {
                    $component = $file->getBasename('.blade.php');

                    $blade->component('ui::components.' . $component, $component);
                }
            }
        });
    }

    /**
     * @param SplFileInfo $file
     * @return array
     */
    private function sanitize(SplFileInfo $file): array
    {
        $component = Str::snake($file->getBasename('.php'), '-');
        $class = $this->getClassname($file);

        return [$component, $class];
    }

    /**
     * @param SplFileInfo $file
     * @return string|null
     */
    private function getClassname(SplFileInfo $file)
    {
        if (preg_match('#^namespace\s+(.+?);$#sm', $file->getContents(), $matches)) {
            return "{$matches[1]}\\{$file->getBasename('.php')}";
        }

        return null;
    }
}