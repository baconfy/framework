<?php

namespace Baconfy\Traits\Loaders;

use Illuminate\View\Compilers\BladeCompiler;

trait ViewsTrait
{
    /**
     * Load view from container path
     * @param $directory
     */
    protected function loadModuleViews($directory)
    {
        $this->loadViewsFrom($this->getClassDirectory($directory), $this->name);
    }

    /**
     * Register the given view components with a custom prefix.
     *
     * @param  string  $prefix
     * @param  array  $components
     * @return void
     */
    protected function loadViewComponentsAs($prefix, array $components)
    {
        $this->callAfterResolving(BladeCompiler::class, function ($blade) use ($prefix, $components) {
            foreach ($components as $alias => $component) {
                $blade->component($component, is_string($alias) ? $alias : null, $prefix);
            }
        });
    }
}
